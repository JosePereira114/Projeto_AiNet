@extends('layouts.main')

@section('header-title', 'Estatísticas')

@section('main')

@endsection


<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="chart-container max-w-3xl mx-auto">
            <canvas id="myChart"></canvas>
        </div>

        <div class="mt-6 flex justify-center">
            <div class="bg-blue-200 text-blue-800 px-4 py-2 rounded-lg shadow-md mr-4">
                <span class="font-semibold">Most Tickets Sold ({{ $totalTickets }}):</span> {{ $maxGenre->tickets_sold }} tickets sold 
            </div>
            <div class="bg-red-200 text-red-800 px-4 py-2 rounded-lg shadow-md">
                <span class="font-semibold">Least Tickets Sold ({{ $minGenre->genre }}):</span> {{ $minGenre->tickets_sold }} tickets sold
            </div>
        </div>
    </div>
</body>