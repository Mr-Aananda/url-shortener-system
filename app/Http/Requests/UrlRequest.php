<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrlRequest extends FormRequest
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
            'long_url' => 'required|url|max:2048',
            'short_url' => 'nullable|string|max:25|unique:urls,short_url' . ($this->isMethod('put') ? ',' . $this->route('url') : ''),
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'long_url.required' => 'The long URL is required.',
            'long_url.url' => 'The long URL must be a valid URL.',
            'long_url.max' => 'The long URL must not exceed 2048 characters.',
            'short_url.max' => 'The short URL must not exceed 25 characters.',
            'short_url.unique' => 'The short URL has already been taken.',
        ];
    }
}
