@extends('layouts.main')

@section('header-title', 'List of Movies at the Moment')

@section('main')
@if(session('pdf-path'))
<div class="alert alert-success">
    <a href="{{ route('cart.downloadPdf') }}" class="btn btn-primary" style="background-color: #007bff; color: #fff; border-color: #007bff;">
        <span>CLICK HERE TO:</span> Download Receipt
    </a>
</div>
@endif
<div class="flex flex-col">
    @each('movies.shared.cardmoment', $movies, 'movie')
</div>
@endsection