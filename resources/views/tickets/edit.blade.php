@extends('layouts.main')

@section('header-title', 'Ticket "' . $ticket->id . '"')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('tickets.create', ['ticket' => $ticket]) }}"
                        text="New"
                        type="success"/>
                    <x-button
                        href="{{ route('tickets.show', ['ticket' => $ticket]) }}"
                        text="View"
                        type="info"/>
                    <form method="POST" action="{{ route('tickets.destroy', ['ticket' => $ticket]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Edit ticket "{{ $ticket->id }}"
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Save" button to store the information.
                    </p>
                </header>

                <form method="POST" action="{{ route('tickets.update', ['ticket' => $ticket]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('tickets.shared.fields', ['mode' => 'edit'])
                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Save" class="uppercase"/>
                        <x-button element="a" type="light" text="Cancel" class="uppercase ms-4"
                                    href="{{ route('tickets.index') }}"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

