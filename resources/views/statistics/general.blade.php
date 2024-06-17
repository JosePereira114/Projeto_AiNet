@extends('layouts.main')

@section('header-title', 'Estatísticas')

@section('main')


<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="chart-container max-w-3xl mx-auto">
            <canvas id="myChart"></canvas>
        </div>

        <div class="mt-6 flex justify-center">
            <div class="bg-blue-200 text-blue-800 px-4 py-2 rounded-lg shadow-md mr-4">
                <span class="font-semibold">Total Tickets Sold: {{ $totalTickets }}</span>
            </div>
            <div class="bg-blue-200 text-blue-800 px-4 py-2 rounded-lg shadow-md mr-4">
                <span class="font-semibold">Total Screenings: {{ $totalScreenings }}</span>
            </div>
            @foreach ($genres_countmovies as $genre)
            <span class="font-semibold">Numero de filmes por Género:</span>
            <div class="bg-blue-200 text-blue-800 px-4 py-2 rounded-lg shadow-md mr-4">
                <span class="font-semibold">{{ $genre->name }}:  {{ $genre->movies_count }}</span>
            </div>
            @endforeach 
            
            
        </div>
    </div>
</body>



@endsection