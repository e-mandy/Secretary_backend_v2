<?php

namespace App\Services;

use App\Models\Matter;

class MatterService{
    public function index(){
        $matters = Matter::select("id", "name");
    }
}