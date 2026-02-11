<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
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
     */ public function rules(): array
    {
        return [
            'Status' => 'bail|required|in:pending,accepted,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The Applicant Status is required .',
            'status.in' => 'The Applicant Status must be one of the following: pending, accepted, rejected.',
    #
        ];
    }
}
