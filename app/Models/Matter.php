<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public function professors(){
        return $this->belongsToMany(Professor::class, "professor_matter");
    }
}
