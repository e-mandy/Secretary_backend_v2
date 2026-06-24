<?php

namespace App\Http\Requests\DefenseReport;

use App\Enums\FiliereType;
use App\Enums\OptionType;
use Illuminate\Foundation\Http\FormRequest;

class StoreDefenseReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "theme" => ["required", "string", "max:255"],
            "owner" => ["required", "string"],
            "note" => ["required", "decimal:0,2"],
            "option" => ["required", OptionType::class],
            "filiere" => ["required", FiliereType::class],
            "file" => ["required", "file", "mimes:pdf", "max:4096"]
        ];
    }
}
