<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomUpdateRequest extends FormRequest
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
            "room_number" => ['required'],
            "maximum_occupancy" => ['required'],
            "occupancy_status" => ['required','bool'],
            "number_of_beds" => ['required']
        ];
    }
    public function messages()
    {
        return [
            "id.required" => "Please Select a room"
        ];
    }
}
