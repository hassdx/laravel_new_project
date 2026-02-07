<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            job categories {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-x auto p-6">
        <x-toast-notification />

        <div class="flex justify-end items-center mb-4">
            <div>

                @if (request()->input('archived') == 'true')

                    {{-- active --}}
                    <a href="{{ route('job-category.index') }}"
                        class="bg-black hover:bg-gray-700-700 text-white font-bold py-2 px-4 rounded">Active categories</a>

                @else
                    {{-- archived --}}
                    <a href="{{ route('job-category.index', ['archived' => 'true']) }}"
                        class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Archived categories</a>

                @endif




                {{-- add job Category button --}}
                <a href="{{ route('job-category.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Add Job Category</a>


            </div>
        </div>
        {{-- job categories table --}}

        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class=" border-b">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if (request()->input('archived') == 'true')
                                    {{-- restore button --}}
                                    <form action="{{ route('job-category.restore', $category->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                                    </form>

                                @else

                                    {{-- edite button --}}

                                    <a href="{{ route('job-category.edit', $category->id) }}"
                                        class="text-blue-500 havor:text-blue-700">✍️ Edit</a>

                                    {{-- delete button --}}
                                    <form action="{{ route('job-category.destroy', $category->id) }}" method="POST"
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
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No job categories found.</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{-- pagination --}}
            {{ $categories->links() }}
        </div>

    </div>

</x-app-layout>