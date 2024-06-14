<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function showChart()
    {
        // Agregar os dados por mês
        $data = Ticket::select(
            DB::raw('MONTH(screenings.date) as month'),
            DB::raw('COUNT(*) as tickets_sold')
        )
        ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
        ->groupBy(DB::raw('MONTH(screenings.date)'))
        ->orderBy(DB::raw('MONTH(screenings.date)'))
        ->get()
        ->pluck('tickets_sold', 'month')
        ->toArray();

        // Criar um array com os meses e os dados correspondentes
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $data[$i] ?? 0;
        }

        return view('charts', compact('chartData', 'months'));
    }
}
