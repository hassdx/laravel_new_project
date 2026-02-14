<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 gap-2">
        {{-- overveiw card --}}
        <div class="grid grid-cols-3 gap-6 mb-6">
            {{-- total jobs --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-midiume  text-gray-900">Active Users</h3>
                    <p class="text-2xl font-bold text-indigo-500">{{ $analytics['activeUsers'] }}</p>
                    <p class="text-sm font-medium text-gray-500">Last 30 days</p>
                </div>
            </div>

            {{-- total jobs --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-midiume  text-gray-900">Total Jobs</h3>
                    <p class="text-2xl font-bold text-indigo-500">{{ $analytics['totalJobs'] }}</p>
                    <p class="text-sm font-medium text-gray-500">All Time</p>
                </div>
            </div>

            {{-- total jobs --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-midiume  text-gray-900">Total Applications</h3>
                    <p class="text-2xl font-bold text-indigo-500">{{ $analytics['totalApplications'] }}</p>
                    <p class="text-sm font-medium text-gray-500">All Time</p>
                </div>
            </div>

        </div>

        {{-- most appleid job --}}

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-bold  text-gray-900">Most Applied Jobs</h3>

                <table class="w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class=" py-2 text-gray-500">Job Title </th>
                            @if (auth()->user()->role == 'admin')
                                <th class=" py-2 text-gray-500">Company</th>
                            @endif
                            <th class=" py-2 text-gray-500">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['mostAppliedJobs'] as $job)
                            <tr>
                                <th class="py-4">{{ $job->title }}</th>
                                <th class="py-4">{{ $job->company->name }}</th>
                                <th class="py-4">{{ $job->totalCount }}</th>
                            </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        {{-- conversion rates --}}

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 ">
                <h3 class="text-lg font-bold  text-gray-900">Conversion Rates</h3>

                <table class="w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class=" py-2 text-gray-500">Job Title</th>
                            <th class=" py-2 text-gray-500">Veiws</th>
                            <th class=" py-2 text-gray-500">Applications</th>
                            <th class=" py-2 text-gray-500">Conversions Rates</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['conversionRates'] as $conversionRate)
                            <tr>
                                <th class="py-4">{{ $conversionRate->title }}</th>
                                <th class="py-4">{{ $conversionRate->viewCount }}</th>
                                <th class="py-4">{{ $conversionRate->totalCount }}</th>
                                <th class="py-4">{{ $conversionRate->conversionRate }}%</th>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>

    </div>
</x-app-layout>