<?php

namespace App\Http\Controllers\ApiController\Matter;

use App\Services\MatterService;

class MatterController{
    public function __construct(
        public MatterService $service
    ){}

    public function index(){
        $response = $this->service->index();

        return response()->json([
            'type' => "All Matters",
            "message" => "Matières chargée avec succès",
            "data" => $response
        ], 200);
    }
}