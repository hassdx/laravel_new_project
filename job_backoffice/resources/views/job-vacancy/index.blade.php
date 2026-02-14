<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{  ('Job Vacancies')}} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-x auto p-6">
        <x-toast-notification />

        <div class="flex justify-end items-center mb-4 ">
            <div>

                @if (request()->input('archived') == 'true')

                    {{-- active --}}
                    <a href="{{ route('job-vacancies.index') }}"
                        class="bg-black hover:bg-gray-700-700 text-white font-bold py-2 px-4  rounded">Active Job
                        Vacancies</a>

                @else
                    {{-- archived --}}
                    <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
                        class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-2 mr-4 rounded">Archived Job
                        Vacancies
                    </a>

                @endif




                {{-- add job Category button --}}
                <a href="{{ route('job-vacancies.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Add Job Vacancies</a>


            </div>
        </div>
        {{-- job categories table --}}

        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                    @if(auth()->user()->role == 'admin')
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($jobVacancies as $jobVacancy)
                    <tr class=" border-b">
                        @if (request()->input('archived') == 'true')
                            <td class="px-6 py-4 text-gray-500">{{ $jobVacancy->title }}</td>
                        @else
                            <td class="px-6 py-4 text-gray-800">
                                <a class="text-blue-500 hover:text-blue-700 underline"
                                    href="{{ route('job-vacancies.show', $jobVacancy->id) }}">{{ $jobVacancy->title }}</a>
                            </td>


                        @endif
                        
                        @if (auth()->user()->role == 'admin')
                            <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->company?->name  }}</td>


                        @endif
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->location }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->type }}</td>
                        <td class="px-6 py-4 text-gray-800">$ {{ number_format($jobVacancy->salary, 2)}}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if (request()->input('archived') == 'true')
                                    {{-- restore button --}}
                                    <form action="{{ route('job-vacancies.restore', $jobVacancy->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                                    </form>

                                @else

                                    {{-- edite button --}}

                                    <a href="{{ route('job-vacancies.edit', $jobVacancy->id) }}"
                                        class="text-blue-500 havor:text-blue-700">✍️ Edit</a>

                                    {{-- delete button --}}
                                    <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST"
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
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No job Vacancies found.</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{-- pagination --}}
            {{ $jobVacancies->links() }}
        </div>

    </div>

</x-app-layout>