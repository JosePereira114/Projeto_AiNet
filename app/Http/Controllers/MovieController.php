<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View; 
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;


class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $allMovies = Movie::orderBy('title')->paginate(20);
        return view('movies.index')->with('allMovies', $allMovies);
    }
    public function showCase(): View
    {
        $movies = Movie::paginate(20);
        return view('movies.showcase',['movies' => $movies]);
    }
    public function showMoment(): View
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addWeeks(2)->endOfDay();
        $movies = Movie::whereHas('screenings', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        })->get();

        
        return view('movies.showmoment', ['movies' => $movies]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $newMovie = new Movie();
        return view('movies.create')->with('movie', $newMovie);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $newMovie = Movie::create($request->all());

        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->title}</u></a> has been created successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie):View
    {
        $movie = Movie::findOrFail($movie->id);
        return view('movies.show')->with('movie', $movie);
    }
    public function showScreening(Movie $movie):View
    {
        // O Movie já está injetado e resolve automaticamente pelo ID, não há necessidade de fazer outra consulta.
        $movie->load('screenings'); // Carrega as exibições (screenings) relacionadas ao filme.
        $screenings = $movie->screenings;
        return view('movies.screening',['movie'  => $movie,'screenings' => $screenings]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        return view('movies.edit')->with('movie', $movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $movie->update($request->all());
        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "Movie <a href='$url'><u>{$movie->title}</u></a> has been updated successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        try{
            $url = route('movies.show', ['movie' => $movie]);
            
        }catch(\Exception $error){
            $htmlMessage = "Movie <a href='$url'><u>{$movie->title}</u></a> has been deleted successfully!";
            return redirect()->route('movies.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }
    }
}
