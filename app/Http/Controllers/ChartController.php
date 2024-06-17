<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Screening;
use App\Models\Genre;

class ChartController extends Controller
{
    public function general()
    {
        $totalTickets = Ticket::count();
        $totalScreenings = Screening::count();
        $genres_countmovies = Genre::withCount('movies')->get();
        

        return view('statistics.general', compact('totalTickets', ));
    }

    public function showChart()
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

        return view('statistics.charts', compact('chartData', 'months', 'name', 'maxMonth', 'minMonth'));
    }

    public function showChart2()
{
    // Aggregate the data by genre
    $data = Ticket::select(
        'genres.name as genre',
        DB::raw('COUNT(*) as tickets_sold')
    )
    ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
    ->join('movies', 'screenings.movie_id', '=', 'movies.id')
    ->join('genres', 'movies.genre_code', '=', 'genres.code')
    ->groupBy('genres.name')
    ->orderBy('tickets_sold', 'desc') // Order by tickets_sold descending
    ->get();

    $maxGenre = $data->first(); // Genre with the most tickets sold
    $minGenre = $data->last(); // Genre with the least tickets sold

    $totalGenres = count($data);
    $totalTickets = $data->sum('tickets_sold');
    $averageTickets = $totalGenres > 0 ? round($totalTickets / $totalGenres, 2) : 0;

    $genres = $data->pluck('genre');
    $chartData = $data->pluck('tickets_sold');

    $name = "Tickets Sold per Genre";

    return view('statistics.charts2', compact('chartData', 'genres', 'name', 'maxGenre', 'minGenre'));
}
}
