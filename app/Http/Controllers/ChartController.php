<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

    public function showChart2()
    {
        // Agregar os dados por mês
        $data = Ticket::select(
            DB::raw('MONTH(screenings.date) as month'),
            DB::raw('COUNT(*) as tickets_sold')
        )
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->groupBy(DB::raw('MONTH(screenings.date)'))
            ->orderBy(DB::raw('tickets_sold'), 'desc') // Order by tickets_sold descending
            ->get();

        $maxMonth = $data->first(); // Month with the most tickets sold
        $minMonth = $data->last(); // Month with the least tickets sold
        
        $totalMonths = count($data);
        $totalTickets = $data->sum('tickets_sold');
        $averageTickets = $totalMonths > 0 ? round($totalTickets / $totalMonths, 2) : 0;

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = [];
        foreach ($months as $key => $month) {
            $chartData[$key] = $data->where('month', $key + 1)->first()->tickets_sold ?? 0;
        }

        $name = "Tickets Sold per Month";

        return view('charts', compact('chartData', 'months', 'name', 'maxMonth', 'minMonth', 'averageTickets'));
    }
}
