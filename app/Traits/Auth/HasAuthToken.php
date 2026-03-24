<?php

namespace App\Traits\Auth;

use Laravel\Sanctum\NewAccessToken;

trait HasAuthToken{


    /**
     * The function which generates access token
    */
    public function generateAccesToken(int $delayInMinutes = 15): NewAccessToken
    {
        return $this->createToken(
            'access_token',
            // To ensure that the token has the ability to access to api features.
            ['access'],
            now()->addMinute($delayInMinutes)
        );
    }

    
    /**
     * The function which generates refresh token
     */
    public function generateRefreshToken(int $delayInDays = 7): NewAccessToken
    {
        return $this->createToken(
            'refresh_token',
            // To ensure that refresh token only have the privilege to refresh tokens
            ['refresh'],
            now()->addDays($delayInDays)
        );
    }


    /**
     * The function which determines the token expiry delay
     */
    public function getTokenExpiryDelay(NewAccessToken $token): int
    {
        return now()->diffInSeconds($token->accessToken->expires_at);
    }
}