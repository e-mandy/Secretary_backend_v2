<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\AdminRequest;

readonly class AdminDTO{
    public function __construct(
        public string $email,
        public string $password
    ){}

    public static function fromRequest(AdminRequest $request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password')
        );
    }
}