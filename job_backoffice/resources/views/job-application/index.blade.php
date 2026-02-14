<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{  ('Job applications')}} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-x auto p-6">
        <x-toast-notification />

        <div class="flex justify-end items-center mb-4 ">
            <div>

                @if (request()->input('archived') == 'true')

                    {{-- active --}}
                    <a href="{{ route('job-applications.index') }}"
                        class="bg-black hover:bg-gray-700-700 text-white font-bold py-2 px-4 mr-2 rounded">Active Job applications</a>

                @else
                    {{-- archived --}}
                    <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                        class="bg-black hover:bg-gray-700 text-white font-bold py-2 px- rounded">Archived Job Vacancies
                    </a>

                @endif
            </div>

        </div>
        {{-- job categories table --}}

        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Position (Job Vacancy)</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($jobApplications as $jobApplication)
                    <tr class=" border-b">
                        @if (request()->input('archived') == 'true')
                            <td class="px-6 py-4 text-gray-500">{{ $jobApplication->user->name }}</td>
                        @else
                            <td class="px-6 py-4 text-gray-800">
                                <a class="text-blue-500 hover:text-blue-700 underline"
                                    href="{{ route('job-vacancies.show', $jobApplication->id) }}">{{ $jobApplication->user->name }}</a>
                            </td>


                        @endif

                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy->title  }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy->company->name }}</td>
                        <td class="px-6 py-4 @if ($jobApplication->status == 'pending') text-yellow-500 @elseif ($jobApplication->status == 'accepted') text-green-500 @elseif ($jobApplication->status == 'rejected') text-red-500
                        
                        @endif">{{ $jobApplication->status }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if (request()->input('archived') == 'true')
                                    {{-- restore button --}}
                                    <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                                    </form>

                                @else

                                    {{-- edite button --}}

                                    <a href="{{ route('job-applications.edit', $jobApplication->id) }}"
                                        class="text-blue-500 havor:text-blue-700">✍️ Edit</a>

                                    {{-- delete button --}}
                                    <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                    </form>

                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No Applications found.</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{-- pagination --}}
            {{ $jobApplications->links() }}
        </div>

    </div>

</x-app-layout>