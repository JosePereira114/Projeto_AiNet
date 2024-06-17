@extends('layouts.main')

@section('header-title', 'Screening "' . $screening->id . '"')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    @can('create', App\Models\Screening::class)
                    <x-button
                        href="{{ route('screenings.create', ['screening' => $screening]) }}"
                        text="New"
                        type="success"/>
                    @endcan
                    @can('update', App\Models\Screening::class)
                    <x-button
                        href="{{ route('screenings.edit', ['screening' => $screening]) }}"
                        text="Edit"
                        type="primary"/>
                    @endcan
                    @can('delete', App\Models\Screening::class)
                    <form method="POST" action="{{ route('screenings.destroy', ['screening' => $screening]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                    @endcan
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Screening "{{ $screening->name }}"
                    </h2>
                </header>
                @include('screenings.shared.fields', ['mode' => 'show'])
                @can('viewAny', App\Models\QrCode::class)
                <div>
                    <form method="POST" action="{{ route('screenings.processUrl', ['screening' => $screening]) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">URL</label>
                            <input id="url" name="url" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200" placeholder="Enter URL">
                        </div>
                        <x-button
                            element="submit"
                            text="Submit"
                            type="primary"/>
                    </form>
                </div>
                @endcan
            </section>
        </div>
    </div>
</div>
@endsection
