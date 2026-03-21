<?php

use App\DTOs\Professor\ProfessorStoreDTO;
use App\Models\Professor;

class ProfessorService{
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

        return [
            "lastname" => $professor->lastname,
            "firstname" => $professor->firstanme,
            "email" => $professor->email,
            "matters" => $professor->matters
        ];
    }
}