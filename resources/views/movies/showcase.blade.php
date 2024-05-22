@extends('layouts.main')

@section('header-title', 'List of All Movies')

@section('main')
    <div class="flex flex-col">
        @each('movies.shared.card', $movies, 'movie')
    </div>
@endsection
