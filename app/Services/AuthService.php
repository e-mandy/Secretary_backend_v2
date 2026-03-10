<?php

namespace App\Services;

use App\DTOs\Auth\AdminDTO;
use App\DTOs\Auth\LoginSecretaryDTO;
use App\DTOs\Auth\RegisterSecretaryDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService{

    public function loginAsAdmin(AdminDTO $data){
        // Check if the email exists in the database
        $user = User::where('email', $data->email)->first();
        
        if(!$user) throw new \Exception("Données invalides");

        $isMatch = Hash::check($data->password, $user->password);
        if(!$isMatch) throw new \Exception("Données invalides");

        $token = $user->createToken(
            "Token Connexion User: " . $user->email,
            ["*"]
        );

        return [
            "user" => [
                "email" => $user->email,
                "lastname" => $user->lastname,
                "firstname" => $user->firstname,
                "role" => $user->role
            ],
            "access_token" => $token
        ];
    }

    public function registerAsSecretary(RegisterSecretaryDTO  $data){
        // Check if there is already a user with the same email
        $existingUser = User::where('email', $data->email);

        if($existingUser) throw new \Exception("Utilisateur déjà existant");

        $newUser = User::create([
            "lastname" => $data->lastname,
            "firstname" => $data->firstname,
            "email" => $data->email,
            "password" => Hash::make($data->password),
            "role" => "secretariat"
        ]);

        $token = $newUser->createToken("Token Register User: ". $data->email);

        return [
            "user" => [
                "email" => $newUser->email,
                "lastname" => $newUser->lastname,
                "firstname" => $newUser->firstname,
                "role" => $newUser->role
            ],
            "access_token" => $token
        ];
    }

    public function loginAsSecretary(LoginSecretaryDTO $data){
        // Check if the email exists in the database
        $user = User::where('email', $data->email)->first();

        if(!$user) throw new \Exception("Données invalides");

        $isMatch = Hash::check($data->password, $user->password);
        if(!$isMatch) throw new \Exception("Données invalides");

        $token = $user->createToken("Token Connexion User: " . $user->email);

        return [
            "user" => [
                "email" => $user->email,
                "lastname" => $user->lastname,
                "firstname" => $user->firstname,
                "role" => $user->role
            ],
            "access_token" => $token
        ];
    }
}