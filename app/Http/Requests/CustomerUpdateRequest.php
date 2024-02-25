<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            "id" => ['required'],
            "name" => ['required'],
            "age" => ['required','numeric'],
            "address" => ['required'],
            "citizenship_no" => ['required'],
            "phone_no" => ['required','digits:10'],
        ];
    }
    public function messages()
    {
        return [
            "id.required" => "Please Select a customer"
        ];
    }
}
