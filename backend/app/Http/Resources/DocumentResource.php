<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contract_title' => $this->title,
            'metadata' => [
                'size' => $this->file_size,
                "type" => $this->file_mime_type,
            ],
            'url' => $this->file_url,
            'created_at' => $this->created_at
        ];
    }
}
