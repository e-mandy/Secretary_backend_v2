<?php

namespace App\Services;

use App\DTOs\Professor\ProfessorStoreDTO;
use App\DTOs\Professor\ProfessorUpdateDTO;
use App\Http\Requests\Professor\StoreProfessorRequest;
use App\Http\Resources\ProfessorResource;
use App\Models\Document;
use App\Models\Professor;
use Illuminate\Support\Facades\DB;
use SearchProfessorDTO;

class ProfessorService{

    public function index(){
        $professors = Professor::limit(10)->get();

        return ProfessorResource::collection($professors);
    }

    public function store(ProfessorStoreDTO $data, StoreProfessorRequest $request){
        return DB::transaction(function() use ($data, $request){

            $existingProf = Professor::where('email', $data->email)->first();
    
            // If the email for the professor already exists in the database.
            if($existingProf) abort(400, "Cet email existe déjà.");
    
            // We create the professor
            $professor = Professor::create([
                "lastname" => $data->lastname,
                "firstname" => $data->firstname,
                "email" => $data->email
            ]);

            // We check some likely documents
            if($request->hasFile("documents")){
                foreach($request->file("documents") as $file){
                    $file_path = $file->store('uploads/documents', 'public');

                    $documentData = [
                        "title" => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                        "file_path" => $file_path,
                        "file_mime_type" => $file->getClientMimeType(),
                        "file_size" => $file->getSize(),
                        "professor_id" => $professor->id
                    ];

                    $document = Document::create($documentData);
                }
            }
    
            // To attach the professor to his different matters.ers);
            $professor->matters()->attach($data->matters);
            $professor->load('matters');
    
            return new ProfessorResource($professor);
        });
    }

    /**
     * @param array<\Illuminate\Http\UploadedFile> $files
     */
    public function addDocument(Professor $professor, array $files){
        if(!$files) abort(404, "Aucun fichier uploadé.");

        foreach($files as $file){
            $file_path = $file->store("uploads/documents", "public");

            $professor->documents()->create([
                "title" => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                "file_path" => $file_path,
                "file_mime_type" => $file->getClientMimeType(),
                "file_size" => $file->getSize()
                // professor_id is already in the table.
            ]);
        }

        return true;
    }

    public function show(Professor $professor){
        return new ProfessorResource($professor->load(["matters", "documents"]));
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
        if($professor->has("matters")) $professor->matters()->detach();

        return $professor->delete();
    }

    public function search(SearchProfessorDTO $data){
        $professors = Professor::query()
            ->where("email", $data->search)
            ->orWhere("lastname", $data->search)
            ->orWhere("firstname", $data->search)
            ->orderBy('created_at')
            ->select("id", "lastname", "firstname");

        return $professors;
    }
}