<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant Status') }}
        </h2>
    </x-slot>

    <div class="overflow-x auto p-6">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form action="{{ route('job-aapplications.update',['job_application' => $jobApoplication->id, 'redirectToList' => request()->query('redirectToList')]) }}" class="w-full" enctype="multipart/form-data" accept-charset="UTF-8" id="edit-job-vacancy-form-{{ $jobVacancy }}" method="POST">
                @csrf
                @method('PUT')

                {{-- jobApplication Deitails --}}
                <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow">
                    <h3 class="text-lg font-large ">Job jobApplication details</h3>
                    <p class="text-sm mb-2"> Enter the details of the jobApplication</p>

                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Applicant Name</label>
                      <span>{{ $jobApoplication->user->name }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Applicant Email</label>
                       <span>{{ $jobApoplication->user->email }}</span>
                    </div>

                     <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Position (Job Vacancy)</label>
                       <span>{{ $jobApoplication->jobVacancy->title }}</span>
                    </div>

                     <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Company</label>
                       <span>{{ $jobApoplication->jobVacancy->company->name }}</span>
                    </div>

                     <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">AI generated feedback</label>
                       <span>{{ $jobApoplication->aiGeneratedFeedback }}</span>
                    </div>

                     <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">AI generated Scoore</label>
                       <span>{{ $jobApoplication->aiGeneratedScore }}</span>
                    </div>
                

                   

                    <div class="mb-4">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="Status"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                            <option value="pending" {{ old('type', $jobApoplication->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ old('type', $jobApoplication->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="accepted" {{ old('type', $jobApoplication->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            
                        </select>
                    </div>

                   
                <div class="flex justify-end items-center">
                    <a href="{{ route('job-applications.index',) }}" class="text-gray-700 mr-2 ">Cancel</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        update Applicant Status

                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>