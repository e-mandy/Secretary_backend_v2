<?php

use App\DTOs\DefenseReport\CreateDefenseReportDTO;
use App\Http\Requests\DefenseReport\StoreDefenseReportRequest;

class DefenseReportService {
    public function create(CreateDefenseReportDTO $data, StoreDefenseReportRequest $request){
        if(!$request->hasFile($data->file)) abort(400, "Vous devez charger le pv de soutenance !!");
    }
}