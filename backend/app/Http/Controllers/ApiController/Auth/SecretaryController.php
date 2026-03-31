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

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Inscription d'une secrétaire",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"firstname","lastname","email","password"},
     *             @OA\Property(property="firstname", type="string", example="Marie"),
     *             @OA\Property(property="lastname", type="string", example="Dupont"),
     *             @OA\Property(property="email", type="string", example="marie@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="type", type="string", example="Sécrétariat Register"),
     *             @OA\Property(property="message", type="string", example="Utilisateur crée avec succès")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erreur de validation ou email déjà utilisé",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cet email est déjà utilisé")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Connexion d'une secrétaire",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="marie@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="type", type="string", example="Sécrétariat Login"),
     *             @OA\Property(property="message", type="string", example="Utilisateur connecté avec succès"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="email", type="string"),
     *                     @OA\Property(property="lastname", type="string"),
     *                     @OA\Property(property="firstname", type="string"),
     *                     @OA\Property(property="role", type="string")
     *                 ),
     *                 @OA\Property(property="access_token", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Données invalides")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/auth/verify/{id}/{hash}",
     *     summary="Vérification de l'email d'une secrétaire",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="hash",
     *         in="path",
     *         required=true,
     *         description="Hash de vérification",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Secrétaire vérifiée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sécrétaire vérifié avec succès"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="email", type="string"),
     *                     @OA\Property(property="lastname", type="string"),
     *                     @OA\Property(property="firstname", type="string"),
     *                     @OA\Property(property="role", type="string")
     *                 ),
     *                 @OA\Property(property="access_token", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Lien de vérification invalide",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lien invalide")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/auth/refresh",
     *     summary="Rafraîchissement du token d'accès",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Token rafraîchi avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User re-logged"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="lastname", type="string"),
     *                 @OA\Property(property="firstname", type="string"),
     *                 @OA\Property(property="role", type="string")
     *             ),
     *             @OA\Property(property="access_token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token introuvable",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token introuvable")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Token invalide ou expiré",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token invalide")
     *         )
     *     )
     * )
     */
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
        
        $cookie = cookie(
            "refreshToken",
            $response["refresh_token"],
            (int) env("APP_TOKEN_DURATION"),
            "/",
            null,
            false,
            true,
            false,
            "Lax"
        );
        return response()->json([
            "message" => "User re-logged",
            "user" => $response["user"],
            "access_token" => $response["access_token"]
        ])->withCookie($cookie);
    }
}
