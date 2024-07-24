<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordUserRequest extends FormRequest
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
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'The password is required.',
            'new_password.required' => 'The password is required.',
            'new_password.string' => 'The password must be a string.',
            'new_password.min' => 'The password must be at least 8 characters.',
            'new_password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
