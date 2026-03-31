<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        "title",
        "file_size",
        "description",
        "file_path",
        "file_mime_type",
    ];

    // To ensure that the "file_url" method will be include in the document model
    protected $appends = ["file_url"];

    // Accessor to display the file size
    protected function file_url(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->file_path)
        );
    }

}