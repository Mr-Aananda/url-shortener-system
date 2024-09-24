<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('URL Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Long URL') }}: {{ $url->long_url }}</h3>
                <h4 class="mt-2">
                    {{ __('Short URL') }}:
                    <a href="{{ route('url.redirect', $url->short_url) }}" class="text-blue-500 underline" target="__blank">
                        {{ url($url->short_url) }}
                    </a>
                </h4>

                <p class="mt-2">{{ __('Click Count') }}: {{ $url->click_count }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
