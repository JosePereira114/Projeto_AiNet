@extends('layouts.main')

@section('header-title', 'Estatísticas')

@section('main')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficos</title>
    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="chart-container max-w-3xl mx-auto">
            <canvas id="myChart"></canvas>
        </div>

        <div class="mt-6 flex justify-center">
            <div class="bg-blue-200 text-blue-800 px-4 py-2 rounded-lg shadow-md mr-4">
                <span class="font-semibold">Most Tickets Sold ({{ $maxGenre->genre }}):</span> {{ $maxGenre->tickets_sold }} tickets sold 
            </div>
            <div class="bg-red-200 text-red-800 px-4 py-2 rounded-lg shadow-md">
                <span class="font-semibold">Least Tickets Sold ({{ $minGenre->genre }}):</span> {{ $minGenre->tickets_sold }} tickets sold
            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($genres),
                datasets: [{
                    label: @json($name),
                    data: @json($chartData),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
@endsection
