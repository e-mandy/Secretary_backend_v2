<?php

namespace App\Http\Controllers\ApiController\Professor;

use App\DTOs\Professor\ProfessorStoreDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Professor\StoreProfessorRequest;
use ProfessorService;

class ProfessorController extends Controller
{
    public function __construct(
        public ProfessorService $service
    )
    {}

    public function store(StoreProfessorRequest $request){
        $data = ProfessorStoreDTO::fromRequest($request);

        $response = $this->service->store($data);

        return response()->json([
            "type" => "Professor Storage",
            "data" => [
                "professor" => $response
            ]
        ], 201);
    }
}
