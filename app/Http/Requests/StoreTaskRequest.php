<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    private const STATUS_OPTIONS = ['pending', 'in progress', 'completed'];
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', self::STATUS_OPTIONS),
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The selected status is invalid. Valid options are: ' . implode(', ', self::STATUS_OPTIONS),
        ];
    }
}
