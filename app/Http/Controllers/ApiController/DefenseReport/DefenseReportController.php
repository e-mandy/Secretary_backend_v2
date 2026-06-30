<?php

namespace App\Http\Controllers\ApiController\DefenseReport;

use App\DTOs\DefenseReport\CreateDefenseReportDTO;
use App\DTOs\DefenseReport\UpdateDefenseReportDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\DefenseReport\StoreDefenseReportRequest;
use App\Http\Requests\DefenseReport\UpdateDefenseReportRequest;
use App\Models\DefenseReport;
use App\Services\DefenseReportService;

class DefenseReportController extends Controller
{
    public function __construct(
        public DefenseReportService $service
    ){}

    public function index(){
        $response = $this->service->index();

        return response()->json([
            'type' => 'Get Defense Reports',
            'data' => $response,
        ], 200);
    }

    public function create(StoreDefenseReportRequest $request){
        $data = CreateDefenseReportDTO::fromRequest($request);

        $response = $this->service->create($data);

        return response()->json([
            'type' => 'Defense Report Storage',
            'message' => 'PV de soutenance créé avec succès',
            'data' => $response,
        ], 201);
    }

    public function show(DefenseReport $defenseReport){
        $response = $this->service->show($defenseReport);

        return response()->json([
            'type' => 'Get Defense Report',
            'data' => $response,
        ], 200);
    }

    public function update(DefenseReport $defenseReport, UpdateDefenseReportRequest $request){
        $data = UpdateDefenseReportDTO::fromRequest($request);

        $response = $this->service->update($defenseReport, $data);

        return response()->json([
            'type' => 'Defense Report Update',
            'message' => 'PV de soutenance mis à jour avec succès',
            'data' => $response,
        ], 200);
    }

    public function delete(DefenseReport $defenseReport){
        $this->service->destroy($defenseReport);

        return response()->json([
            'type' => 'Defense Report Delete',
            'message' => 'PV de soutenance supprimé avec succès',
        ], 200);
    }
}
