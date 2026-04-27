<?php

namespace App\Http\Requests\Professor;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfessorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "lastname" => ["required", "string"],
            "firstname" => ["required", "string"],
            "email" => ["required", "email", "string", "unique:professors"],
            "matters" => ["required", "array"],
            // Check if the matters in the table exist in the database table.
            "matters*" => ["exists:matters,id"]
        ];
    }
}
