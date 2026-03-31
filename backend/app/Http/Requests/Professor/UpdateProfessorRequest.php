<?php

namespace App\Http\Requests\Professor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfessorRequest extends FormRequest
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
            
            "lastname" => ["sometimes", "string"],
            "firstname" => ["sometimes",  "string"],
            "email" => ["sometimes", "email"],
            "matters" => ['nullable', "array"],
            "matters*" => ["exists:matters,id"]
        ];
    }
}
