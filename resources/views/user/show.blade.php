<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section class="mb-6">
                    <header class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('User Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Detailed information about the user.") }}
                            </p>
                        </div>

                        <a href="{{ route('user.index') }}" class="inline-flex items-center px-3 py-1 text-gray-700 bg-gray-200 border border-transparent rounded-md text-xs font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Back to Users List
                        </a>
                    </header>
                </section>

                <section>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Name</h3>
                            <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Email</h3>
                            <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Created At</h3>
                            <p class="mt-1 text-gray-900">{{ $user->created_at->format('F j, Y, g:i a') }}</p>
                        </div>
                    </div>
                </section>

                <section class="mt-6">
                    <a href="{{ route('user.edit', $user->id) }}" class="inline-flex items-center px-3 py-1 text-gray-700 bg-gray-200 border border-transparent rounded-md text-xs font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Edit User
                    </a>
                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline-block ms-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-1 text-gray-700 bg-gray-200 border border-transparent rounded-md text-xs font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Delete User
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
