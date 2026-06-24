<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefenseReport extends Model
{
    protected $fillable = [
        "owner",
        "theme",
        "defense_date",
        "filiere",
        "note",
        "option",
        "file_path"
    ];
}
