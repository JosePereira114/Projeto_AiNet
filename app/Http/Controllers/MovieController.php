<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


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
        return view('movies.showcase', ['movies' => $movies]);
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
    public function showMomentScreenings(Movie $movie): View
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addWeeks(2)->endOfDay();

        $screenings = $movie->screenings()
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        return view('movies.selectscreening', ['movie' => $movie, 'screenings' => $screenings]);
    }
    public function create(): View
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
    public function show(Movie $movie): View
    {
        $movie = Movie::findOrFail($movie->id);
        return view('movies.show')->with('movie', $movie);
    }
    public function showScreening(Movie $movie): View
    {
        // O Movie já está injetado e resolve automaticamente pelo ID, não há necessidade de fazer outra consulta.
        $movie->load('screenings'); // Carrega as exibições (screenings) relacionadas ao filme.
        $screenings = $movie->screenings;
        return view('movies.screening', ['movie'  => $movie, 'screenings' => $screenings]);
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
        try {
            $url = route('movies.show', ['movie' => $movie]);~
            $totalGenres = DB::scalar('select count(*) from genres where movie = ?', [$movie->id]);
            $totalScreenings=$movie->screenings()->count();
            if($totalGenres==0&&$totalScreenings==0){
                $movie->delete();
                if($movie->imageExists){
                    Storage::delete("public/poster/{$movie->getImageFileName()}");
                }
                $alertType='success';
                $alertMsg = "Movie <a href='$url'><u>{$movie->title}</u></a> has been deleted successfully!";
            }else{
                $alertType='warning';
                $genresStr = match(true){
                    $totalGenres<=0=>"",
                    $totalGenres==1=>"there is 1 genre enrolled in this movie",
                    $totalGenres> 1 =>"there are $totalGenres genres enrolled in this movie"
                };
                $screeningsStr = match(true){
                    $totalScreenings<=0=>"",
                    $totalScreenings==1=>"there is 1 screening enrolled in this movie",
                    $totalScreenings> 1 =>"there are $totalScreenings screenings enrolled in this movie"
                };
                $justification = $genresStr.($totalGenres>0&&$totalScreenings>0?" and ":"").$screeningsStr;
                $alertMsg="Movie <a href='$url'><u>{$movie->title}</u></a> could not be deleted because $justification.";
            }
                
            
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Movie
                          <a href='$url'><u>{$movie->title}</u></a>
                          because there was an error with the operation!.";
        }
        return redirect()->route('movies.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
    public function destroyImage(Movie $movie): RedirectResponse
    {
        if ($movie->imageExists) {
            Storage::delete("public/posters/{$movie->getImageFileName()}");
        }
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Image of course {$movie->name} has been deleted.");
    }
}
