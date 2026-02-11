<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('edit job vacancy') }}
        </h2>
    </x-slot>

    <div class="overflow-x auto p-6">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form action="{{ route('job-vacancies.update',['job_vacancy' => $jobVacancy->id, 'redirectToList' => request()->query('redirectToList')]) }}" class="w-full" enctype="multipart/form-data" accept-charset="UTF-8" id="edit-job-vacancy-form-{{ $jobVacancy }}" method="POST">
                @csrf
                @method('PUT')

                {{-- company Deitails --}}
                <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow">
                    <h3 class="text-lg font-large ">Job vacancy details</h3>
                    <p class="text-sm mb-2"> slelect the details of the Job vacancy</p>

                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Job title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $jobVacancy->title)}}"
                            class="{{ $errors->has('title') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                            placeholder="Enter Company title" >
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="mb-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $jobVacancy->location) }}"
                            class="{{ $errors->has('location') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                            placeholder="Enter location" >
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block mb-2 text-sm font-medium text-gray-700">Expected Salary (USD)
                            </label>
                        <input type="number" name="salary" id="salary" value="{{ old('salary', $jobVacancy->salary) }}"
                            class="{{ $errors->has('salary') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                            placeholder="Enter Company salary">
                        @error('salary')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>


                    <div class="mb-4">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                            <option value="Full-Time" {{ old('type', $jobVacancy->type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Hybrid" {{ old('type', $jobVacancy->type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="Remote" {{ old('type', $jobVacancy->type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                            <option value="Contract" {{ old('type', $jobVacancy->type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                            
                        </select>
                    </div>

                    
                    {{-- company select doropdown --}}
                    <div class="mb-4">
                        <label for="companyId" class="block mb-2 text-sm font-medium text-gray-700">Company</label>
                        <select name="companyId" id="companyId"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ old('companyId', $jobVacancy->companyId) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('companyId')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- job category select doropdown --}}
                    <div class="mb-4">
                        <label for="job_categorrId" class="block mb-2 text-sm font-medium text-gray-700">Job Category</label>
                        <select name="jobCategoryId" id="jobCategoryId"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                            @foreach ($jobCategories as $jobCategory)
                                <option value="{{ $jobCategory->id }}" {{ old('job_categoryId', $jobVacancy->jobCategoryId) == $jobCategory->id ? 'selected' : '' }}>
                                    {{ $jobCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('job_categoryId')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- job description --}}
                    <div class="mb-4">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Job description</label>
                        <textarea name="description" id="description" rows="4"
                            class="{{ $errors->has('description') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                            placeholder="Enter job description">{{ old('description', $jobVacancy->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                </div>
                <div class="flex justify-end items-center">
                    <a href="{{ route('job-vacancies.index',) }}" class="text-gray-700 mr-2 ">Cancel</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        update job Vacancy

                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>