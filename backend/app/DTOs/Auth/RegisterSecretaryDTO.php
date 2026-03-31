<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\RegisterSecretaryRequest;

readonly class RegisterSecretaryDTO{
    public function __construct(
        public string $lastname,
        public string $firstname,
        public string $email,
        public string $password
    ){}

    public static function fromRequest(RegisterSecretaryRequest $request) : self
    {
        $data = $request->validated();

        return new self(
            lastname: $request->input('lastname'),
            firstname: $request->input('firstname'),
            email: $request->input('email'),
            password: $request->input('password')
        );
    }
}
