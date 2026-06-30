<?php

namespace App\Http\Requests\DefenseReport;

use App\Enums\FiliereType;
use App\Enums\OptionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreDefenseReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "theme" => ["required", "string", "max:255"],
            "owner" => ["required", "string"],
            "note" => ["required", "decimal:0,2"],
            "option" => ["required", new Enum(OptionType::class)],
            "filiere" => ["required", new Enum(FiliereType::class)],
            "defense_date" => ["required", "date_format:Y-m-d"],
            "file" => ["required", "file", "mimes:pdf", "max:4096"]
        ];
    }
}
