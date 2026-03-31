<?php

namespace App\Http\Controllers\ApiController\Professor;

use App\DTOs\Professor\ProfessorStoreDTO;
use App\DTOs\Professor\ProfessorUpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Professor\StoreProfessorRequest;
use App\Http\Requests\Professor\UpdateProfessorRequest;
use App\Models\Professor;
use App\Services\ProfessorService;

class ProfessorController extends Controller
{
    public function __construct(
        public ProfessorService $service
    )
    {}

    /**
     * @OA\Get(
     *     path="/api/secretary/professors",
     *     summary="Lister tous les professeurs",
     *     tags={"Professors"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des professeurs",
     *         @OA\JsonContent(
     *             @OA\Property(property="type", type="string", example="Get Professors"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="firstname", type="string", example="Jean"),
     *                     @OA\Property(property="lastname", type="string", example="Dupont"),
     *                     @OA\Property(property="email", type="string", example="jean@example.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function index(){
        $response = $this->service->index();

        return response()->json([
            "type" => "Get Professors",
            "data" => $response
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/secretary/professors",
     *     summary="Créer un professeur",
     *     tags={"Professors"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"firstname","lastname","email"},
     *             @OA\Property(property="firstname", type="string", example="Jean"),
     *             @OA\Property(property="lastname", type="string", example="Dupont"),
     *             @OA\Property(property="email", type="string", example="jean@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Professeur créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="type", type="string", example="Professor Storage"),
     *             @OA\Property(property="message", type="string", example="Professeur creé avec succès"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="professor", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="firstname", type="string", example="Jean"),
     *                     @OA\Property(property="lastname", type="string", example="Dupont"),
     *                     @OA\Property(property="email", type="string", example="jean@example.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function create(StoreProfessorRequest $request){
        $data = ProfessorStoreDTO::fromRequest($request);

        $response = $this->service->store($data);

        return response()->json([
            "type" => "Professor Storage",
            "message" => "Professeur creé avec succès",
            "data" => [
                "professor" => $response
            ]
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/secretary/professors/{professor}",
     *     summary="Modifier un professeur",
     *     tags={"Professors"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="professor",
     *         in="path",
     *         required=true,
     *         description="ID du professeur",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="firstname", type="string", example="Jean"),
     *             @OA\Property(property="lastname", type="string", example="Dupont"),
     *             @OA\Property(property="email", type="string", example="jean@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Professeur modifié avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="type", type="string", example="Professor Update"),
     *             @OA\Property(property="message", type="string", example="Informations du professeur modifiées avec succès"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="professor", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="firstname", type="string", example="Jean"),
     *                     @OA\Property(property="lastname", type="string", example="Dupont"),
     *                     @OA\Property(property="email", type="string", example="jean@example.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function update(Professor $professor, UpdateProfessorRequest $request){
        $data = ProfessorUpdateDTO::fromRequest($request);

        $response = $this->service->update($professor, $data);

        return response()->json([
            "type" => "Professor Update",
            "message" => "Informations du professeur modifiées avec succès",
            "data" => [
                "professor" => $response
            ]
        ], 200);
    }

    /**
 * @OA\Delete(
 *     path="/api/secretary/professors/{professor}",
 *     summary="Supprimer un professeur",
 *     tags={"Professors"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="professor",
 *         in="path",
 *         required=true,
 *         description="ID du professeur",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Professeur supprimé avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="type", type="string", example="Professor Delete"),
 *             @OA\Property(property="message", type="string", example="Professeur supprimé avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non authentifié",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated")
 *         )
 *     )
 * )
 */
    public function delete(Professor $professor){
        $response = $this->service->destroy($professor);

        if($response) return response()->json([
            "type" => "Professor Delete",
            "message" => "Professeur supprimé avec succès"
        ], 204);
        // The 204 status for NO CONTENT
    }
}
