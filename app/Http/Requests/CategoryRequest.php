<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    use CheckUpdateCase;
    private const MODULE_NAME = 'category';
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
            'category_name' => ['required','string', 'max:200', Rule::unique('categories')->ignore($this->route('category'))],
        ];
    }

    public function attributes()
    {
        return [
            'category_name' => trans('category.name'),
        ];
    }
}
