@props(['name', 'label', 'value', 'readonly'])

@php
    // Use Carbon para formatar o valor da data
    $formattedValue = $value ? \Carbon\Carbon::parse($value)->format('Y-n-j') : '';
@endphp

<div>
    <label for="{{ $name }}" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="date" value="{{ $formattedValue }}"
           class="appearance-none block mt-1 w-full
                  bg-white dark:bg-gray-900
                  text-black dark:text-gray-50
                  @error($name)
                      border-red-500 dark:border-red-500
                  @else
                      border-gray-300 dark:border-gray-700
                  @enderror
                  focus:border-indigo-500 dark:focus:border-indigo-400
                  focus:ring-indigo-500 dark:focus:ring-indigo-400
                  rounded-md shadow-sm
                  disabled:rounded-none disabled:shadow-none
                  disabled:border-t-transparent disabled:border-x-transparent
                  disabled:border-dashed
                  disabled:opacity-100
                  disabled:select-none"
           {{ $readonly ? 'readonly' : '' }} autofocus="autofocus">
    @error($name)
        <div class="text-sm text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
