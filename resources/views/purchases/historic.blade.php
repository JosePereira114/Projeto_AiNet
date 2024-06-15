@extends('layouts.main')

@section('header-title', 'Historic '.Auth::user()->name.'')

@section('main')
<div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
            @if($purchases->isEmpty())
                <p class="text-lg font-medium text-gray-900 dark:text-gray-100">You have no purchases yet</p>
            @else

                @foreach ($purchases as $purchase)
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Purchase "{{ $purchase->id }}" made on {{ $purchase->created_at->format('d/m/Y') }} and cousts ${{ $purchase->total_price }}
                            </h2>
                            <x-tickets.table :tickets="$purchase->tickets"
                            :showView="false"
                            :showEdit="false"
                            :showDelete="false"
                            />
                        </header>
                        <div class="mt-6 space
                @endforeach
            @endif
            </div>
        </div>
    </div>
@endsection