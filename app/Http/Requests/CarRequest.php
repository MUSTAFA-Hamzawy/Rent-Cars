<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    use CheckUpdateCase;
    const ALLOWED_EXTENSION = 'jpg,jpeg,png';
    const MODULE_NAME = 'car';
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
        $isUpdateCase = $this->isUpdateCase();
        return [
            'car_year' => ['required', 'int', 'min:1900', 'max:' . date('Y')],
            'car_color' => ['required'],
            'car_rent_price' => ['required', 'numeric', 'min:1', 'max:32767'],
            'car_branch' => ['required', 'int'],
            'car_brand' => ['required', 'int'],
            'car_category' => ['required', 'int'],
            'car_model' => ['required', 'int'],
            'car_distance_limit' => ['nullable', 'numeric', 'min:0', 'max:2147483647'],
            'over_distance_fees' => ['nullable', 'numeric', 'min:0', 'max:32767'],
            'car_images' => [$isUpdateCase ? 'nullable':'required', 'array'],
            'car_images.*' => ['image', 'mimes:' . self::ALLOWED_EXTENSION, 'max:4096'],

        ];
    }
}
