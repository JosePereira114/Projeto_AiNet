@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
@php
    if(Auth::user()){
            $customer = \App\Models\Customer::where('id', Auth::user()->id)->first();
    }
@endphp

<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        @empty($cart)
        <h3 class="text-xl w-96 text-center">Cart is Empty</h3>
        @else
        <div class="font-base text-sm text-gray-700 dark:text-gray-300">
            <x-seats.table :seats="$cart" :showView="false" :showEdit="false" :showDelete="false" :showAddToCart="false" :showRemoveFromCart="true" />

        </div>
        <div class="mt-12">
            <div class="flex justify-between space-x-12 items-end">
                <div>
                    <h3 class="mb-4 text-xl">Shopping Cart Confirmation </h3>
                <form action="{{ route('cart.confirm') }}" method="post">
                        @csrf
                        <x-field.input name="customer_name" label="Customer Name" width="lg" value="{{ old('customer_name',Auth::user()?->name)}}" />
                        <x-field.input name="customer_email" label="Customer Email" width="lg" value="{{ old('customer_email',Auth::user()?->email) }}" />
                        <x-field.input name="customer_nif" label="Customer Nif" width="lg" value="{{ old('customer_nif', $customer?->nif ) }}" />
                        <x-field.select name="payment_type" label="Payment_type" :options="['VISA' => 'VISA', 'PAYPAL' => 'PAYPAL', 'MBWAY' => 'MBWAY']" value="{{ old('payment_type',$customer->payment_type)}}" />
                        <x-field.input name="payment_ref" label="Payment_ref" value="{{ old('payment_ref',$customer->payment_ref) }}" />
                        <x-button element="submit" type="dark" text="Confirm" class="mt-4" />
                    </form>
                </div>
                <div>
                    <form action="{{ route('cart.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <x-button element="submit" type="danger" text="Clear Cart" class="mt-4" />
                    </form>
                </div>
            </div>
        </div>
        @endempty
    </div>
</div>
@endsection