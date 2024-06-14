<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Graph</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Statistics Graph</h1>

        <div class="mb-4">
            <h2 class="text-xl font-semibold">Order Statistics</h2>
            <ul>
                @foreach($orderStatistics as $stat)
                    <li>User ID: {{ $stat->user_id }} - Total Amount: ${{ $stat->total_amount }}</li>
                @endforeach
            </ul>
        </div>

        <canvas id="statisticsChart" class="bg-white p-4 rounded shadow-md"></canvas>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('statisticsChart').getContext('2d');
            var chartData = {
                labels: @json($orderStatistics->pluck('user_id')),
                datasets: [{
                    label: 'Total Order Amount',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    data: @json($orderStatistics->pluck('total_amount'))
                }]
            };

            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
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