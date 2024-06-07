@extends('layouts.main')

@section('header-title', $customer->name)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('customers.create', ['customer' => $customer]) }}"
                        text="New"
                        type="success"/>
                    <x-button
                        href="{{ route('customers.edit', ['customer' => $customer]) }}"
                        text="Edit"
                        type="primary"/>
                    <form method="POST" action="{{ route('customers.destroy', ['customer' => $customer]) }}">
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
                        Customer "{{ $customer->name }}"
                    </h2>
                </header>
                <div class="mt-6 space-y-4">
                    @include('customers.shared.fields', ['mode' => 'show'])
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
