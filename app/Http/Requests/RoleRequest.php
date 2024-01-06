<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'permissions' => 'required|array',
        ];

        $nameRule = 'required|unique:roles,name';

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $pageId = $this->route('role')->id;
            $nameRule .= ',' . $pageId;
        }

        $rules['name'] = $nameRule;

        return $rules;
    }

    public function messages(): array
    {
        return [
            'permissions.required' => 'Please select atleast one permission.',
        ];
    }
}
