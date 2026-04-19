<?php

namespace App\Services;

use App\Http\Resources\Matter\MatterResource;
use App\Models\Matter;

class MatterService{
    public function index(){
        $matters = Matter::select("id", "name");

        return MatterResource::collection($matters);
    }
}