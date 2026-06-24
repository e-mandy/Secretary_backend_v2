<?php

namespace App\DTOs\Professor;

use App\Http\Requests\Professor\SearchProfessorRequest;

readonly class SearchProfessorDTO {
    public function __construct(
        public string $search
    ){}

    public static function fromRequest(SearchProfessorRequest $request): self
    {
        return new self(
            search: $request->input('search')
        );
    }
}