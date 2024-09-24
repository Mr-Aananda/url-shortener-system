@props(['id' => null, 'name' => null, 'rows' => 3])

<textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" {{ $attributes->merge(['class' => 'block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50']) }}>{{ $slot }}</textarea>
