<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
           'title' => 'required|string|max:255|unique:job_vacancies,title',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'type' => 'required|string|max:255',
            'jobCategoryId' => 'required|string|max:255',
            'companyId' => 'required|exists:companies,id',
            'company' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'The title has already been taken.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'location.required' => 'The location is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than 255 characters.',
            'salary.required' => 'The salary is required.',
            'salary.numeric' => 'The salary must be a number.',
            'type.required' => 'The type is required.',
            'type.string' => 'The type must be a string.',
            'type.max' => 'The type may not be greater than 255 characters.',
            'jobCategoryId.required' => 'The job category is required.',
            'jobCategoryId.string' => 'The job category must be a string.',
            'jobCategoryId.max' => 'The job category may not be greater than 255 characters.',
            'companyId.required' => 'The company is required.',
            'companyId.exists' => 'The selected company does not exist.',
            'company.string' => 'The company must be a string.',
            'company.max' => 'The company may not be greater than 255 characters.',
        ];
    }
}
