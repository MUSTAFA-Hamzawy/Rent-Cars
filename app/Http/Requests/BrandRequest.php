<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    use CheckUpdateCase;
    private const MODULE_NAME = 'brand';
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
     * @return array
     */
    public function rules(): array
    {
        $isUpdate = $this->isUpdateCase();
        return [
            'brand_name' => ['required','string', 'max:200', Rule::unique('brands')->ignore($this->route('brand'))],
            'brand_logo' => [$isUpdate ? 'nullable' : 'required', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'brand_description' => ['nullable','string'],
        ];
    }

    public function attributes()
    {
        return [
            'brand_name' => trans('brand.name'),
            'brand_logo' => trans('brand.logo'),
            'brand_description' => trans('brand.description')
        ];
    }
}
