<?php

namespace App\Services;

use App\DTOs\Auth\AdminDTO;
use App\DTOs\Auth\LoginSecretaryDTO;
use App\DTOs\Auth\RegisterEmailDTO;
use App\DTOs\Auth\RegisterSecretaryDTO;
use App\Mail\Auth\VerifyUserEmail;
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

        $refresh_token = $user->createToken(
            "Refresh Token Connexion User: " . $user->email,
            ["*"],
            now()->addDays(7)
        );

        $access_token = $user->createToken(
            "Access token Connexion User: ". $user->email,
            ["*"],
            now()->addMinute(15)
        );

        

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
            now()->addMinute(20),
            ['id' => $newUser->id, "hash" => sha1($newUser->email)]
        );

        // We change the app_url with the frontend url
        $frontendUrl = str_replace(
            config('app.url') . '/api',
            env('FRONTEND_URL'),
            $emailHash
        );
        
        // Asynchronous send of mail
        Mail::to($newUser)->send(new VerifyUserEmail($newUser, $frontendUrl));
    }

    public function loginAsSecretary(LoginSecretaryDTO $data){
        // Check if the email exists in the database
        $user = User::where('email', $data->email)->first();

        if(!$user) throw new \Exception("Données invalides");

        $isMatch = Hash::check($data->password, $user->password);
        if(!$isMatch) throw new \Exception("Données invalides");

        $refresh_token = $user->createToken(
            "Refresh Token Connexion User: " . $user->email,
            ["*"],
            now()->addDays(7)
        );

        $access_token = $user->createToken(
            "Access token Connexion User: ". $user->email,
            ["*"],
            now()->addMinute(15)
        );

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

    public function verifyEmail(RegisterEmailDTO $data){
        $createdUser = User::findOrFail($data->id);

        if(!hash_equals((string) $data->hash, sha1($createdUser->getEmailForVerification()))) throw new Exception("Lien de vérification invalide");

        if($createdUser->markEmailAsVerified()){
            $access_token = $createdUser->createToken(
                'Token Register User: '. $createdUser->email,

            );
            return [
                "success" => true,
                "data" => [
                    "user" => [
                        "email" => $createdUser->email,
                        "lastname" => $createdUser->lastname,
                        "firstname" => $createdUser->firstname,
                        "role" => $createdUser->role
                    ],
                    "token" => $access_token
                ]
            ];
        }
    }

    public function check(User $user){
        $token = $user->createToken(
            'Token Connexion User: '. $user->email,
            ["*"],
        );

        return [
            "user" => [
                "email" => $user->email,
                "lastname" => $user->lastname,
                "firstname" => $user->firstname,
                "role" => $user->role
            ],
            "token" => $token
        ];
    }
}