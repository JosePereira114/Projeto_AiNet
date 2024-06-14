@extends('layouts.main')

@section('header-title', 'Estatísticas')

@section('main')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bar Chart Example</title>
    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 33.33%;
            /* Define a largura para um terço da tela */
            margin: auto;
            /* Centraliza a div */
        }

        canvas {
            width: 100% !important;
            /* Garante que o canvas preencha a div */
            height: auto !important;
            /* Mantém a proporção do gráfico */
        }
    </style>
</head>

<body>
    <div class="chart-container">
        <canvas id="myChart"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Bilhetes Vendidos',
                    data: <?php echo json_encode($chartData); ?>,
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
@endsection