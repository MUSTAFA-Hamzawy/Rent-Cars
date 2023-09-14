<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'method_name' => ['required','string', 'max:200', Rule::unique('payment_methods')->ignore($this->route('payment_method'))],
        ];
    }

    public function attributes()
    {
        return [
            'method_name' => trans('payment_method.name'),
        ];
    }
}
