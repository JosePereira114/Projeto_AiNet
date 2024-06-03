{{$screening->theater->seats->count()}}
{{$screening->date}}({{$screening->start_time}})
@extends('layouts.main')

@section('header-title', 'Buy a Ticket')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Ticket
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                        Click on "Payment" button to pay the ticket.
                    </p>
                </header>

                <form method="POST" action="{{ route('courses.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mt-6 space-y-4">
                    <input type="number" id="seats_number" name="seats_number" min="0" max="{{$screening->theater->seats->count() - $screening->tickets->count()}}" value="1">
                    </div>
                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Payment" class="uppercase"/>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection