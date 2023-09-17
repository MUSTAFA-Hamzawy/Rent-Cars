<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchRequest extends FormRequest
{
    use CheckUpdateCase;
    private const MODULE_NAME = 'branch';

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
            'branch_name' => ['required','string', 'max:200', Rule::unique('branches')->ignore($this->route('branch'))],
            'work_days'   => ['required', 'array'],
            'payment_methods'   => ['array'],
            'work_hours_start'  => ['required', 'date_format:H:i'],
            'work_hours_end'    => ['required', 'date_format:H:i', 'greater_than_start_hour:work_hours_start'],
        ];
    }

    public function attributes()
    {
        return [
            'branch_name' => __('Branch Name'),
            'work_days' => __('Work Days'),
            'work_hours_start' => __('Starting Work Hour'),
            'work_hours_end' =>  __('Closing Work Hour'),
        ];
    }
}
