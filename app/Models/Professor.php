<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $fillable = [
        "lastname",
        "firstname",
        "email"
    ];

    public function matters(){
        return $this->belongsToMany(Matter::class, "professor_matter");
    }
}
