<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add company') }}
        </h2>
    </x-slot>

    <div class="overflow-x auto p-6">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form action="{{ route('companies.store') }}" method="POST">
                @csrf

                {{-- company Deitails --}}
                <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow">
                    <h3 class="text-lg font-large ">Company details</h3>
                    <p class="text-sm mb-2"> slelect the details of the company</p>

                    <div class="mb-4">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="{{ $errors->has('name') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                            placeholder="Enter Company name" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="mb-4">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}"
                            class="{{ $errors->has('address') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                            placeholder="Enter Address" required>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="mb-4">
                        <label for="Industry" class="block mb-2 text-sm font-medium text-gray-700">Industry</label>
                        <select name="industry" id="industry"
                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm">
                            @foreach ($industries as $industry)
                                <option value="{{ $industry }}" {{ old('industry') == $industry ? 'selected' : '' }}>
                                    {{ $industry }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="website" class="block mb-2 text-sm font-medium text-gray-700">website
                            (optional)</label>
                        <input type="text" name="website" id="website" value="{{ old('website') }}"
                            class="{{ $errors->has('website') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                            placeholder="Enter Company website">
                        @error('website')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>




                    {{-- company Owner --}}
                    <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow">
                        <h3 class="text-lg font-large  ">Company Owner</h3>
                        <p class="text-sm mb-2"> slelect the Owner of the company</p>

                        <div class="mb-4">
                            <label for="Owner_name" class="block mb-2 text-sm font-medium text-gray-700">Owner
                                Name</label>
                            <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}"
                                class="{{ $errors->has('Owner_name') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                                placeholder="Enter Company Owner name" required>
                            @error('Owner_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="mb-4">
                            <label for="Owner_email" class="block mb-2 text-sm font-medium text-gray-700">Owner
                                Email</label>
                            <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email') }}"
                                class="{{ $errors->has('Owner_email') ? 'border-red-500' : ''}} block w-full p-2 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                                placeholder="Enter Company Owner email" required>
                            @error('Owner_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                        </div>

                        {{-- Owner password --}}

                        <div class="mb-4">
                            <label for="Owner_password" class="block mb-2 text-sm font-medium text-gray-700">Owner
                                Password</label>
                            <div class="relative" x-data="{ showPassword: false }">

                                <x-text-input id="owner_password" class="block mt-1 w-full" name="owner_password"
                                    required autocomplete="current-password"
                                    x-bind:type="showPassword ? 'text' : 'password'" />

                                <button type="button"
                                    class="absolute insert-y-0 right-2 flex items-center text-gray-600 ">
                                    {{-- eye closed --}}
                                    <svg x-show="!showPassword" class="w-5 h-5" width=" 800px" height="800px"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>

                                    {{-- /eye open --}}
                                    <svg x-show="showPassword" class="w-5 h-5" width="800px" height="800px"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                                            stroke="#000000" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="flex justify-end items-center">
                    <a href="{{ route('companies.index') }}" class="text-gray-700 mr-2 ">Cancel</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Company

                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>