<?php

namespace App\Services;

use App\DTOs\Auth\AdminDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService{

    public function loginAsAdmin(AdminDTO $data){

        // Check if the email exist in the database
        $user = User::where('email', $data->email)->first();
        
        if(!$user) throw new \Exception("Données invalides");

        $isMatch = Hash::check($data->password, $user->password);
        if(!$isMatch) throw new \Exception("Données invalides");

        $token = $user->createToken("User: " . $user->email);

        return [
            "user" => [
                "email" => $user->email,
                "lastname" => $user->lastname,
                "firstname" => $user->firstname
            ],
            "access_token" => $token
        ];
    }
}