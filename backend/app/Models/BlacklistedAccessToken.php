<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistedAccessToken extends Model
{
    protected $fillable = [
        "token",
        "expires_at",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
