<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View; 
use Illuminate\Http\RedirectResponse;

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
        return view('movies.showcase');
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
        return view('movies.show')->with('movie', $movie);
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
