<?php

namespace App\Http\Controllers\ApiController\Professor;

use App\DTOs\Professor\ProfessorStoreDTO;
use App\DTOs\Professor\ProfessorUpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Professor\SearchProfessorRequest;
use App\Http\Requests\Professor\StoreProfessorRequest;
use App\Http\Requests\Professor\UpdateProfessorRequest;
use App\Http\Requests\ProfessorAddDocumentRequest;
use App\Models\Professor;
use App\Services\ProfessorService;
use SearchProfessorDTO;

class ProfessorController extends Controller
{
    public function __construct(
        public ProfessorService $service
    )
    {}


    public function index(){
        $response = $this->service->index();

        return response()->json([
            "type" => "Get Professors",
            "data" => $response
        ], 200);
    }

    
    public function create(StoreProfessorRequest $request){
        $data = ProfessorStoreDTO::fromRequest($request);

        $response = $this->service->store($data, $request);

        return response()->json([
            "type" => "Professor Storage",
            "message" => "Professeur creé avec succès",
            "data" => $response
        ], 201);
    }

    public function addDocument(Professor $professor, ProfessorAddDocumentRequest $request){
        $response = $this->service->addDocument($professor, $request->file("documents"));

        if(!$response) abort(500, "Erreur lors de l'ajout de documents.");

        return response()->json([
            "type" => "Adding documents to Professor",
            "message" => "Ajout du(es) document(es) avec succès"
        ], 201);
    }

    public function show(Professor $professor){
        $response = $this->service->show($professor);

        return response()->json([
            "type" => "Get Professor",
            "data" => $response,
            "message" => "Professeur trouvé avec succès"
        ], 200);
    }


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

    
    public function delete(Professor $professor){
        $response = $this->service->destroy($professor);

        if($response) return response()->json([
            "type" => "Professor Delete",
            "message" => "Professeur supprimé avec succès"
        ], 200);
        // The 204 status for NO CONTENT
    }

    public function search(SearchProfessorRequest $request){
        $data = SearchProfessorDTO::fromRequest($request);

        $response = $this->service->search($data);

        return response()->json([
            "type" => "Professor research",
            "message" => "Professeurs correspondant à la recherche.",
            "data" => $response
        ], 200);
    }
}
