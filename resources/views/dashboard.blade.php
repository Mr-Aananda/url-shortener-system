<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Welcome to Your Dashboard!</h1>
                    <p class="text-lg mb-4">Here’s a snapshot of your current activity:</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-2">Total Users</h3>
                            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-2">Total URLs (All Users)</h3>
                            <p class="text-2xl font-bold">{{ $totalUrls }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-2">Your URLs</h3>
                            <p class="text-2xl font-bold">{{ $userUrls }}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-2">Your Total Clicks</h3>
                            <p class="text-2xl font-bold">{{ $totalClicks }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
