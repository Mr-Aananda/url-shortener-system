<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit URL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section class="mb-6">
                    <header class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Edit URL') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update the details below to edit the shortened URL.") }}
                            </p>
                        </div>

                        <a href="{{ route('url.index') }}" class="inline-flex items-center px-3 py-1 text-gray-700 bg-gray-200 border border-transparent rounded-md text-xs font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            All URLs
                        </a>
                    </header>
                </section>

                <x-alert />

                <section>
                    <form method="POST" action="{{ route('url.update', $url->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Long URL -->
                        <div>
                            <x-input-label for="long_url" :value="__('Long URL')" />
                            <x-text-input id="long_url" class="block mt-1 w-full" type="url" name="long_url" :value="old('long_url', $url->long_url)" required />
                            <x-input-error :messages="$errors->get('long_url')" class="mt-2" />
                        </div>

                        <!-- Short URL -->
                        <div class="mt-4">
                            <x-input-label for="short_url" :value="__('Short URL (optional)')" />
                            <x-text-input id="short_url" class="block mt-1 w-full" type="text" name="short_url" :value="old('short_url', $url->short_url)" maxlength="10" />
                            <x-input-error :messages="$errors->get('short_url')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
