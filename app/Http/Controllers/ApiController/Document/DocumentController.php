<?php

namespace App\Http\Controllers\ApiController\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Services\DocumentService;

class DocumentController extends Controller
{
    public function __construct(
        public DocumentService $service
    )
    {}

    public function store(StoreDocumentRequest $request){
        $response = $this->service->store($request);

        $data = new DocumentResource($response);

        return response()->json([
            "message" => "Document crée avec succès",
            "data" => $data
        ], 201);
    }

    // public function destroy(Document $document){
    //     $response = $this->service->delete($document);

    //     return response()->json([
    //         "message" => $response ? "Contrat supprimé avec succès" : "Erreur de suppression du contrat",
    //     ], $response ? 200 : 500);
    // }

    public function download(Document $document){
        return $this->service->download($document);
    }
}
