<?php

namespace App\DTOs\Auth;

readonly class RegisterEmailDTO{
    public function __construct(
        public string $id,
        public string $hash
    ){}
}