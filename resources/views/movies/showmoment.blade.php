@extends('layouts.main')

@section('header-title', 'List of Movies at the Moment')

@section('main')
    <div class="flex flex-col">
        @each('movies.shared.cardmoment', $movies, 'movie')
    </div>
@endsection
