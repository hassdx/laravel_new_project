<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->name }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- back button --}}
        <a href="{{ route('companies.index') }}"
            class="bg-white-300 border border-gray-400 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mb-4 inline-block">←Back
        </a>

        {{-- company details --}}
        <div>
            <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
                <h3 class="text-lg font-large ">Company Vacancy information</h3>
                <p><strong>Owner:</strong> {{ $jobVacancy->company->name }}</strong></p>
                <p><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                <p><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                <p><strong>Salary:</strong>$ {{ number_format($jobVacancy->salary, 2) }} </p>
                <p><strong>description:</strong> {{ $jobVacancy->description }}</p>

                {{-- edit and archive buttons --}}
                <div class="mt-4 flex justify-end space-x-4 mb-6">
                    <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false']) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>

                    <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to {{ $jobVacancy->archived ? 'unarchive' : 'archive' }} this company?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white rounded-md hover:bg-red-600 font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75"
                            style="background-color: #ef4444; border: 1px solid #dc2626;">
                            {{ $jobVacancy->archived ? 'Unarchive' : 'Archive' }}
                        </button>
                    </form>
                </div>

                {{-- tabs navigation --}}
                <div class="mb-6">
                    <ul class="flex space-x-4">
                        <li>
                            <a href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}"
                                class="px-4 py-2 text-sm text-gray-700 font-semibold {{ request('tab') == 'applications' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">
                                Applicants
                            </a>
                        </li>

                    </ul>
                </div>

                {{-- tab content --}}
                <div class="mt-4">
                    <div id="applicants"
                        class="{{ (request('tab') == 'applicants' || !request('tab')) ? 'block' : 'hidden' }}">
                        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 bg-gray-100 text-left">Applicant Title</th>
                                    <th class="px-4 py-2 bg-gray-100 text-left">Type</th>
                                    <th class="px-4 py-2 bg-gray-100 text-left">Location</th>
                                    <th class="px-4 py-2 bg-gray-100 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobVacancy->jobApplications as $application)
                                    <tr class="border-b">
                                        <td class="px-4 py-2 ">{{ $application->title }}</td>
                                        <td class="px-4 py-2">{{ $application->type }}</td>
                                        <td class="px-4 py-2">{{ $application->location }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('job-applications.show', $application->id) }}"
                                                class="text-blue-500 hover:text-blue-700">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No Applicants found.</td>
                                    </tr>


                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>