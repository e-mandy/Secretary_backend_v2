<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\LoginSecretaryRequest;


readonly class LoginSecretaryDTO{
    public function __construct(
        public string $email,
        public string $password
    ){}

    public static function fromRequest(LoginSecretaryRequest $request): self
    {
        $data = $request->validated();

        return new self(
            email: $data['email'],
            password: $data['password']
        );
    }
}