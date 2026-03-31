<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    protected $fillable = [
        "token",
        "expires_at",
        "revoked_at",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
