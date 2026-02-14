<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>
    <div class="overflow-x auto p-6">
        <x-toast-notification />

        @if (auth()->user()->role == 'admin')

            {{-- back button --}}
            <a href="{{ route('companies.index') }}"
                class="bg-white-300 border border-gray-400 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mb-4 inline-block">←Back
            </a>
        @endif

        {{-- company details --}}
        <div>
            <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
                <h3 class="text-lg font-large ">Company information</h3>
                <p><strong>Owner:</strong> {{ $company->owner->name }}</strong></p>
                <p><strong>Address:</strong> {{ $company->address }}</p>
                <p><strong>Email:</strong> {{ $company->owner->email }}</strong></p>
                <p><strong>Industry:</strong> {{ $company->industry }}</p>
                <p><strong>Website:</strong> <a class="text-blue-500 hover:text-blue-700 underline"
                        href="{{ $company->website }}" target="_blank"> {{ $company->website }}</a></p>
                <div class="mt-4 flex justify-end space-x-4 mb-6">
                    @if (auth()->user()->role == 'company-owner')

                            <a href="{{ route('my-company.edit')}}"
                                class="bg-blue-500 hover:bg-blue-700 mt-4  text-white font-bold py-2 px-4 rounded">Edit</a>
                        </div>

                    @else
                        <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}"
                            class="bg-blue-500 hover:bg-blue-700 mt-4  text-white font-bold py-2 px-4 rounded">Edit</a>
                    @endif

            </div>

            {{-- edit and archive buttons --}}
            <div class="mt-4 flex justify-end space-x-4 mb-6">


                @if (auth()->user()->role == 'admin')
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to {{ $company->archived ? 'unarchive' : 'archive' }} this company?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white rounded-md hover:bg-red-600 font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75"
                            style="background-color: #ef4444; border: 1px solid #dc2626;">
                            {{ $company->archived ? 'Unarchive' : 'Archive' }}
                        </button>
                    </form>
                @endif
            </div>

            @if (auth()->user()->role == 'admin')

                {{-- tabs navigation --}}
                <div class="mb-6">
                    <ul class="flex space-x-4">
                        <li>
                            <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                                class="px-4 py-2 text-sm text-gray-700 font-semibold {{ request('tab') == 'jobs' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">
                                Jobs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applicants']) }}"
                                class="px-4 py-2 text-sm text-gray-700 font-semibold {{ request('tab') == 'applicants' ? 'border-b-2 border-blue-500' : '' }}">
                                Applicants
                            </a>
                        </li>
                    </ul>
                </div>



                {{-- tab content --}}
                <div class="mt-4">
                    <div id="jobs" class="{{ request('tab') == 'jobs' || request('tab') == '' ? 'block' : 'hidden' }}">
                        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 bg-gray-100 text-left">Job Title</th>
                                    <th class="px-4 py-2 bg-gray-100 text-left">Type</th>
                                    <th class="px-4 py-2 bg-gray-100 text-left">Location</th>
                                    <th class="px-4 py-2 bg-gray-100 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($company->jobVacancies as $job)
                                    <tr class="border-b">
                                        <td class="px-4 py-2 ">{{ $job->title }}</td>
                                        <td class="px-4 py-2">{{ $job->type }}</td>
                                        <td class="px-4 py-2">{{ $job->location }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                                class="text-blue-500 hover:text-blue-700">View</a>
                                        </td>
                                    </tr>


                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Applicantions tab --}}
                <div id="applicants" class="{{ request('tab') == 'applicants' ? 'block' : 'hidden' }}">

                    <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-100 text-left">Applicant Name</th>
                                <th class="px-4 py-2 bg-gray-100 text-left">Job Title</th>
                                <th class="px-4 py-2 bg-gray-100 text-left">Status</th>
                                <th class="px-4 py-2 bg-gray-100 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($company->jobApplications as $application)
                                <tr class="border-b">
                                    <td class="px-4 py-2 ">{{ $application->user_name }}</td>
                                    <td class="px-4 py-2">{{ $application->jobVacancy->title }}</td>
                                    <td class="px-4 py-2">{{ $application->status }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('job-applications.show', $application->id) }}"
                                            class="text-blue-500 hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                        No applications found for this company.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
</x-app-layout>