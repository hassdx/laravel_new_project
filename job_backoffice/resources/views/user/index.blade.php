<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{  ('Users')}} {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>


    <div class="overflow-x auto p-6">
        <x-toast-notification />

        <div class="flex justify-end items-center mb-4">
            <div>

                @if (request()->input('archived') == 'true')

                    {{-- active --}}
                    <a href="{{ route('users.index') }}"
                        class="bg-black hover:bg-gray-700-700 text-white font-bold py-2 px-4 mr-2 rounded">Active Users</a>

                @else
                    {{-- archived --}}
                    <a href="{{ route('users.index', ['archived' => 'true']) }}"
                        class="bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Archived Users
                    </a>

                @endif
            </div>

        </div>
        {{-- job categories table --}}

        <table class="min-w-full divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class=" border-b">
                        @if (request()->input('archived') == 'true')
                            <td class="px-6 py-4 text-gray-500">{{ $user->name }}</td>
                        @else
                            <td class="px-6 py-4 text-gray-800">
                                <span class="text-gray-500">{{ $user->name }}</span>
                            </td>


                        @endif

                        <td class="px-6 py-4 text-gray-800">{{ $user->email   }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $user->role  }}</td>

                        <td>
                            <div class="flex space-x-4">
                                @if (request()->input('archived') == 'true')
                                    {{-- restore button --}}
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                                    </form>
                                @else
                                    {{-- if addmin dont allow to edit or delete --}}
                                    @if ($user->role != 'admin')
                                        {{-- edit button --}}
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 havor:text-blue-700">✍️
                                            Edit</a>
                                        {{-- archived botton --}}
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                        </form>
                                    @endif

                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No Users found.</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{-- pagination --}}
            {{ $users->links() }}
        </div>

    </div>

</x-app-layout>