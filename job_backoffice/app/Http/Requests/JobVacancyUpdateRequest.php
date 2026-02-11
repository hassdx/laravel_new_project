<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
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
            'title'         => 'required|string|max:255',
            'location'      => 'required|string|max:255',
            'salary'        => 'required|numeric',
            'companyId'     => 'required|exists:companies,id',      // Match the array key
            'jobCategoryId' => 'required|exists:job_categories,id', // Match the array key
            'description'   => 'required|string',
            'type'          => 'nullable|string', // I noticed 'type' was missing from your dd()!
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'location.required' => 'The location is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than 255 characters.',
            'salary.required' => 'The salary is required.',
            'salary.numeric' => 'The salary must be a number.',
            'companyId.required' => 'The company is required.',
            'companyId.exists' => 'The selected company does not exist.',
            'jobCategoryId.required' => 'The job category is required.',
            'jobCategoryId.exists' => 'The selected job category does not exist.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
        ];
    }
}
