<?php

namespace App\Services;

use App\Http\Requests\StoreContractRequest;
use App\Models\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentService{
    public function store(StoreContractRequest $request){
        $file = $request->file('documents');
        $file_path = $file->store('uploads/documents', 'public');

        $data = [
            "title" => $request->input('title'),
            "file_path" => $file_path,
            "file_mime_type" => $file->getMimeType(),
            "file_size" => $file->getSize(),
            "description" => $request->input("description")
        ];

        $document = Document::create($data);

        return $document;
    }

    public function download(Document $document){
        if(!Storage::disk('public')->exists($document->file_path)) abort(404, "Fichier introuvable sur le serveur");

        $file_extenstion = pathinfo($document->file_path, PATHINFO_EXTENSION);
        $file_name = Str::slug($document->title, ' ') . "." . $file_extenstion;

        return Storage::download($document->file_path, $file_name);
    }

    public function update(Document $document, Array $data, ?UploadedFile $newFile = null){
        if($newFile){
            $file_path = $newFile->store('uploads/contracts', 'public');
            if($file_path) Storage::disk('public')->delete($document->file_path);
            $data = [
                ...$data,
                "file_size" => $newFile->getSize(),
                "file_mime_type" => $newFile->getMimeType(),
                "file_path" => $file_path
            ];
        }

        $document->update($data);

        return $document->fresh();
    }

    public function delete(Document $document){
        $path = $document->file_path;
        $result = $document->delete() ? Storage::disk('public')->delete($path) : false;

        return $result;
    }
}