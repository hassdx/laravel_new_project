<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add job categories') }}
        </h2>
    </x-slot>

    <div class="overflow-x auto p-6">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form action="{{ route('job-category.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name " value="{{ old('name') }}"
                        class="{{ $errors->has('name') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                        placeholder="Enter category name" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end items-center">
                    <a href="{{ route('job-category.index') }}" class="text-gray-700 mr-2 ">Cancel</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Category

                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>