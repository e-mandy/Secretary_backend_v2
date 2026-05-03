<?php

namespace App\Services;

use App\DTOs\Auth\AdminDTO;
use App\DTOs\Auth\LoginSecretaryDTO;
use App\DTOs\Auth\RegisterEmailDTO;
use App\DTOs\Auth\RegisterSecretaryDTO;
use App\Mail\Auth\VerifyUserEmail;
use App\Models\RefreshToken;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthService{

    public function loginAsAdmin(AdminDTO $data){
        // Check if the email exists in the database
        $user = User::where('email', $data->email)->first();
        
        if(!$user) throw new \Exception("Données invalides");

        $isMatch = Hash::check($data->password, $user->password);
        if(!$isMatch) throw new \Exception("Données invalides");

        $access_token = $user->generateAccesToken();
        
        $refresh_token = $user->generateRefreshToken();

        $user->refresh_token()->create([
            "token" => $refresh_token->plainTextToken,
            "expires_at" => $user->getTokenExpiryDelay($refresh_token)
        ]);

        return [
            "user" => [
                "email" => $user->email,
                "lastname" => $user->lastname,
                "firstname" => $user->firstname,
                "role" => $user->role
            ],
            "access_token" => $access_token,
            "refresh_token" => $refresh_token
        ];
    }

    public function registerAsSecretary(RegisterSecretaryDTO  $data){
        // Check if there is already a user with the same email
        $existingUser = User::where('email', $data->email)->first();

        if($existingUser !== null) throw new \Exception("Utilisateur déjà existant");

        $newUser = User::create([
            "lastname" => $data->lastname,
            "firstname" => $data->firstname,
            "email" => $data->email,
            "password" => Hash::make($data->password),
            "role" => "secretariat"
        ]);

        $emailHash = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(20),
            ['id' => $newUser->id, "hash" => sha1($newUser->email)],
            false
        );

        // We cleanly construct the frontend URL, replacing the /api prefix from the generated route
        $frontendUrl = rtrim(env('FRONTEND_URL'), '/') . preg_replace('|^/api|', '', $emailHash);

        // Asynchronous send of mail
        Mail::to($newUser)->send(new VerifyUserEmail($newUser, $frontendUrl));
    }

    public function loginAsSecretary(LoginSecretaryDTO $data){
        // Check if the email exists in the database
        $user = User::where('email', $data->email)->first();

        if(!$user) throw new \Exception("Données invalides");

        $isMatch = Hash::check($data->password, $user->password);
        if(!$isMatch) throw new \Exception("Données invalides");

        $access_token = $user->generateAccesToken();
        
        $refresh_token = $user->generateRefreshToken();

        $user->refresh_tokens()->create([
            "token" => $refresh_token->plainTextToken,
            "expires_at" => $user->getTokenExpiryDelay($refresh_token)
        ]);

        return [
            "user" => [
                "email" => $user->email,
                "lastname" => $user->lastname,
                "firstname" => $user->firstname,
                "role" => $user->role
            ],
            "access_token" => $access_token->plainTextToken,
            "refresh_token" => $refresh_token->plainTextToken
        ];
    }

    public function verifyEmail(RegisterEmailDTO $data){
        $createdUser = User::findOrFail($data->id);

        if(!hash_equals((string) $data->hash, sha1($createdUser->getEmailForVerification()))) throw new Exception("Lien de vérification invalide");

        if($createdUser->markEmailAsVerified()){
            $access_token = $createdUser->generateAccesToken();
        
            $refresh_token = $createdUser->generateRefreshToken();

            $createdUser->refresh_tokens()->create([
                "token" => $refresh_token->plainTextToken,
                "expires_at" => $createdUser->getTokenExpiryDelay($refresh_token)
            ]);

            return [
                "success" => true,
                "data" => [
                    "user" => [
                        "email" => $createdUser->email,
                        "lastname" => $createdUser->lastname,
                        "firstname" => $createdUser->firstname,
                        "role" => $createdUser->role
                    ],
                    "access_token" => $access_token->plainTextToken,
                    "refresh_token" => $refresh_token->plainTextToken
                ]
            ];
        }
    }

    public function refresh(User $user, $lastRefreshToken){
        
        $value = RefreshToken::where("token", $lastRefreshToken)->update([
            "revoked_at" => now()
        ]);

        $access_token = $user->generateAccesToken();

        $refresh_token = $user->generateRefreshToken();

        $user->refresh_tokens()->create([
            "token" => $refresh_token->plainTextToken,
            "expires_at" => $user->getTokenExpiryDelay($refresh_token)
        ]);

        return [
            "user" => [
                "email" => $user->email,
                "lastname" => $user->lastname,
                "firstname" => $user->firstname,
                "role" => $user->role
            ],
            "access_token" => $access_token->plainTextToken,
            "refresh_token" => $refresh_token->plainTextToken
        ];
    }
}