<?php

namespace App\Http\Controllers\ApiController\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Services\DocumentService;

class DocumentController extends Controller
{
    public function __construct(
        public DocumentService $service
    )
    {}

     /**
     * @OA\Post(
     *     path="/api/documents",
     *     summary="Créer un contrat",
     *     tags={"Documents"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"file"},
     *                 @OA\Property(property="file", type="string", format="binary", description="Fichier du contrat")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contrat créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contrat crée avec succès"),
     *             @OA\Property(property="data", type="object")
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
    public function store(StoreContractRequest $request){
        $response = $this->service->store($request);

        $data = new DocumentResource($response);

        return response()->json([
            "message" => "Contrat crée avec succès",
            "data" => $data
        ], 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/documents/{document}",
     *     summary="Supprimer un contrat",
     *     tags={"Documents"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="document",
     *         in="path",
     *         required=true,
     *         description="ID du document",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contrat supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contrat supprimé avec succès")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur de suppression",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Erreur de suppression du contrat")
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
    public function destroy(Document $document){
        $response = $this->service->delete($document);

        return response()->json([
            "message" => $response ? "Contrat supprimé avec succès" : "Erreur de suppression du contrat",
        ], $response ? 200 : 500);
    }
}
