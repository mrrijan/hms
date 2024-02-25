<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationUpdateRequest extends FormRequest
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
            "room_id" => ['nullable'],
            "room_id_previous" => ['required_if:room_id,!null'],
            "customer_id" => ['required'],
            "check_in_date" => ['required'],
            "check_out_date" => ['required'],
        ];
    }

    public function messages()
    {
        return [
            "id.required" => "Please select a reservation"
        ];
    }
}
