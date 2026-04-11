<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "lastname" => $this->lastname,
            "firstname" => $this->firstname,
            "email" => $this->email,

            // Now, we have to include the matters for each professor.
            "matters" => MatterResource::collection($this->whenLoaded('matters'))
        ];
    }
}
