<?php

namespace App\DTOs\Professor;

use App\Http\Requests\Professor\UpdateProfessorRequest;

readonly class ProfessorUpdateDTO{
    public function __construct(
        public ?string $lastname,
        public ?string $firstname,
        public ?string $email,
        public ?array $matters
    )
    {}

    public static function fromRequest(UpdateProfessorRequest $request): self
    {
        $data = $request->validated();

        return new self(
            lastname: $data["lastname"],
            firstname: $data["firstname"],
            email: $data["email"],
            matters: $data["matters"]
        );
    }
}