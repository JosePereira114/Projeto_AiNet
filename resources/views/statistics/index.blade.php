<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Graph</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Statistics Graph</h1>

        <div class="mb-4">
            <h2 class="text-xl font-semibold">Total Tickets Sold Per Month</h2>
            <ul class="mb-4">
                @foreach($ticketStatistics as $stat)
                    <li>{{ $stat->year }}-{{ str_pad($stat->month, 2, '0', STR_PAD_LEFT) }}: {{ $stat->total_tickets }} tickets</li>
                @endforeach
            </ul>
        </div>

        <canvas id="statisticsChart" class="bg-white p-4 rounded shadow-md"></canvas>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('statisticsChart').getContext('2d');
            var labels = {!! json_encode($ticketStatistics->map(function($stat) {
                return $stat->year . '-' . str_pad($stat->month, 2, '0', STR_PAD_LEFT);
            })) !!};
            var dataPoints = {!! json_encode($ticketStatistics->pluck('total_tickets')) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Tickets Sold',
                        data: dataPoints,
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
        });
    </script>
</body>
</html>

