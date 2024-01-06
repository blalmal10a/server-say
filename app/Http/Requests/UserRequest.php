<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'roles' => 'nullable',
            'phone' => 'required',
            'password' => 'sometimes|required|confirmed|min:6',
            'password_confirmation' => 'sometimes|required|min:6',
        ];

        // $emailRule = 'required|unique:users,email';

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $emailId = $this->route('user')->id;
            // $emailRule .= ',' . $emailId;
        }

        // $rules['email'] = $emailRule;

        return $rules;
    }

    public function messages(): array
    {
        return [
            'roles.required' => 'Please select atleast one user role.',
        ];
    }
}
