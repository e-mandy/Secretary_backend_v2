<?php

namespace App\Http\Controllers\ApiController\Auth;

use App\DTOs\Auth\LoginSecretaryDTO;
use App\DTOs\Auth\RegisterEmailDTO;
use App\DTOs\Auth\RegisterSecretaryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginSecretaryRequest;
use App\Http\Requests\Auth\RegisterSecretaryRequest;
use App\Services\AuthService;
use App\Traits\Auth\HasAuthToken;
use Exception;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class SecretaryController extends Controller
{
    public function __construct(
        public AuthService $service
    ){}

    public function register(RegisterSecretaryRequest $request){
        $data = RegisterSecretaryDTO::fromRequest($request);

        try{
            $this->service->registerAsSecretary($data);

            return response()->json([
                "type" => "Sécrétariat Register",
                "message" => "Utilisateur crée avec succès",
            ], 201);
        }catch(Exception $e){
            return response()->json([
                "message" => $e->getMessage()
            ], 400);
        }
    }

    public function login(LoginSecretaryRequest $request){
        $data = LoginSecretaryDTO::fromRequest($request);

        try{
            $response = $this->service->loginAsSecretary($data);

            $cookie = cookie("refreshToken", $response['refresh_token']);

            return response()->json([
                "type" => "Sécrétariat Login",
                "message" => "Utilisateur connecté avec succès",
                "data" => [
                    "user" => $response['user'],
                    "access_token" => $response["access_token"]
                ]
            ], 200)->withCookie($cookie);

        }catch(Exception $e){
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }

    public function verify($id, $hash){
        $data = new RegisterEmailDTO((string) $id,  (string) $hash);
        try{
            $response = $this->service->verifyEmail($data);

            $cookie = cookie("refreshToken", $response['data']['refresh_token']);
            
            return response()->json([
                "message" => "Sécrétaire vérifié avec succès",
                "data" => [
                    "user" => $response["data"]['user'],
                    "access_token" => $response["data"]["access_token"]
                ]
            ], 200)->withCookie($cookie);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }
    }

    public function refresh(Request $request){
        $refreshToken = $request->cookie("refreshToken");

        if(!$refreshToken) return response()->json([
            "message" => "Token introuvable"
        ], 401);

        $isVerified = HasAuthToken::verifyToken($refreshToken);
        if(!$isVerified) return response()->json([
            "message" => "Token invalide"
        ], 403);

        // Récupérez le user après tous les checks.
        $user = PersonalAccessToken::findToken($refreshToken)->tokenable;
        
        $response = $this->service->refresh($user, $refreshToken);
        
        $cookie = cookie("refreshToken", $response["refresh_token"], minutes: env("APP_TOKEN_DURATION"), sameSite: "Lax");
        
        return response()->json([
            "message" => "User re-logged",
            "user" => $response["user"],
            "access_token" => $response["access_token"]
        ])->withCookie($cookie);
    }
}
