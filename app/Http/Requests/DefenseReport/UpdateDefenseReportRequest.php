<?php

namespace App\Http\Requests\DefenseReport;

use App\Enums\FiliereType;
use App\Enums\OptionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateDefenseReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "theme" => ["sometimes", "string", "max:255"],
            "owner" => ["sometimes", "string"],
            "note" => ["sometimes", "decimal:0,2"],
            "option" => ["sometimes", new Enum(OptionType::class)],
            "filiere" => ["sometimes", new Enum(FiliereType::class)],
            "defense_date" => ["sometimes", "date_format:Y-m-d"],
            "file" => ["sometimes", "file", "mimes:pdf", "max:4096"]
        ];
    }
}
