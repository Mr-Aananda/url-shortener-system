@if (session('success') || $errors->any())
    <div class="p-4 mb-4 rounded-md {{ session('success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
        @if (session('success'))
            <div class="flex items-center justify-between">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="text-green-700" onclick="this.parentElement.parentElement.remove();">x</button>
            </div>
        @endif

        @if ($errors->any())
            <div>
                <strong>{{ __('Please fix the following errors:') }}</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif
