<?php

namespace App\Services;

use App\DTOs\Professor\ProfessorStoreDTO;
use App\DTOs\Professor\ProfessorUpdateDTO;
use App\Http\Resources\ProfessorResource;
use App\Models\Professor;

class ProfessorService{

    public function index(){
        $professors = Professor::limit(10)->get();

        return ProfessorResource::collection($professors);
    }

    public function store(ProfessorStoreDTO $data){
        $existingProf = Professor::where('email', $data->email)->first();

        // If the email for the professor already exists in the database.
        if($existingProf) abort(400, "Cet email existe déjà.");

        $professor = Professor::create([
            "lastname" => $data->lastname,
            "firstname" => $data->firstname,
            "email" => $data->email
        ]);

        // To attach the professor to his different matters.
        $professor->matters()->attach($data->matters);
        $professor->load('matters');

        return new ProfessorResource($professor);
    }

    public function update(Professor $professor, ProfessorUpdateDTO $data){
        // If there is any update about the table of matters, we synchronize with current database
        if($professor->has("matters")){
            $professor->matters()->sync($data->matters);
        }

        $professor->update([
            "lastname" => $data->lastname,
            "firstname" => $data->firstname,
            "email" => $data->email,
        ]);

        $updatedProf = $professor->fresh();
        $updatedProf->load("matters");

        return new ProfessorResource($updatedProf);
    }

    public function destroy(Professor $professor){
        if($professor->has("matter")) $professor->matters()->detach();

        return $professor->delete();
    }
}