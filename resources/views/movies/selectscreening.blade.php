@extends('layouts.main')

@section('header-title', $movie->title.' Tickets')

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">

                </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Sessões Disponiveis
                    </h2>
                </header>
                <x-movies.screeningMoment :screenings="$movie->screeningsMoment"  :showView="true" class="pt-4" />


            </section>
        </div>
    </div>
</div>
@endsection