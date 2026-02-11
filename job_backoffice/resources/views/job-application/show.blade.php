<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobAoolication->user_name }} applied to {{ $jobAoolication->jobVacancy->title }} 
        </h2>
    </x-slot>
    <div class="overflow-x auto p-6">
        <x-toast-notification />

        {{-- back button --}}
        <a href="{{ route('job-applications.index') }}"
            class="bg-white-300 border border-gray-400 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mb-4 inline-block">←Back </a>

        {{-- application details --}}
        <div>
            <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
                <h3 class="text-lg font-large ">Application details</h3>
                <p><strong>Applicant:</strong> {{ $jobApplication->user_name }}</strong></p>
                <p><strong>Job Vacancy:</strong> {{ $jobApplication->jobVacancy->title }}</p>
                <p><strong>Company:</strong> {{ $jobApplication->jobVacancy->application->name }}</p>
                <p><strong>Status:</strong> <span class="@if($jobApplication->status == 'pending') text-yellow-500 @elseif($jobApplication->status == 'accepted') text-green-500 @elseif($jobApplication->status == 'rejected') text-red-500 @endif"> {{ $jobApplication->status }}</span></p>
                <p><strong>Resume:</strong> <a class="text-blue-500 hover:text-blue-700 underline"
                        href="{{ $jobApplication->resume->url }}" target="_blank"> {{ $jobApplication->resume->url }}</a></p>
             
            </div>

            {{-- edit and archive buttons --}}
            <div class="mt-4 flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-applications.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false']) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>

                <form action="{{ route('job-applications.destroy', ['job_application' => $jobApplication->id]) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to {{ $jobApplication->archived ? 'unarchive' : 'archive' }} this application?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white rounded-md hover:bg-red-600 font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75"
                        style="background-color: #ef4444; border: 1px solid #dc2626;">
                        {{ $application->archived ? 'Unarchive' : 'Archive' }}
                    </button>
                </form>
            </div>

            {{-- tabs navigation --}}
            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'resume']) }}"
                            class="px-4 py-2 text-sm text-gray-700 font-semibold {{ request('tab') == 'jobs' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">
                            Jobs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('companies.show', ['application' => $jobApplication->id, 'tab' => 'AIFeedback']) }}"
                            class="px-4 py-2 text-sm text-gray-700 font-semibold {{ request('tab') == 'AIFeedback' ? 'border-b-2 border-blue-500' : '' }}">
                            Applicants
                        </a>
                    </li>
                </ul>
            </div>

            {{-- tab content --}}
            <div class="mt-4">
            {{-- Resume Tab --}}
                <div id="jobs" class="{{ request('tab') == 'jobs' || request('tab') == '' ? 'block' : 'hidden' }}">
                    <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-100 text-left">Summry</th>
                                <th class="px-4 py-2 bg-gray-100 text-left">Skills</th>
                                <th class="px-4 py-2 bg-gray-100 text-left">Experience</th>
                                <th class="px-4 py-2 bg-gray-100 text-left">Education</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <tr class="border-b">
                                    <td class="px-4 py-2 ">{{ $jobApplication->resume->summary }}</td>
                                    <td class="px-4 py-2">{{ $jobApplication->resume->skills }}</td>
                                    <td class="px-4 py-2">{{ $jobApplication->resume->experience }}</td>
                                    <td class="px-4 py-2">{{ $jobApplication->resume->education }}</td>
                                   
                                </tr>


                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Ai feedback --}}
            <div id="applicants" class="{{ request('tab') == '`AIFeedback' ? 'block' : 'hidden' }}">

                <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-gray-100 text-left">Scoore</th>
                            <th class="px-4 py-2 bg-gray-100 text-left">AI feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr class="border-b">
                                <td class="px-4 py-2 ">{{ $jobAoolication->aiGeneratedScore }}</td>
                                <td class="px-4 py-2">{{ $jobAoolication->aiGeneratedFeedback }}</td>
                                <td class="px-4 py-2">
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    No applications found for this application.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</x-app-layout>