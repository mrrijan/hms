<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentUpdateRequest extends FormRequest
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
            "customer_id" => ['required'],
            "total_amount" => ['required'],
            "advance_payment" => ['nullable'],
            "payment_type" => ['required'],
            "bill_no" => ['required']
        ];
    }
    public function messages()
    {
        return [
            "id.required" => "Please Select a payment"
        ];
    }
}
