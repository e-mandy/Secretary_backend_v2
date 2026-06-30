<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DefenseReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'owner' => $this->owner,
            'theme' => $this->theme,
            'defense_date' => $this->defense_date,
            'filiere' => $this->filiere,
            'option' => $this->option,
            'note' => $this->note,
            'file_url' => Storage::disk('public')->url($this->defense_report_path),
            'created_at' => $this->created_at
        ];
    }
}
