<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allMovies = Genre::orderBy('title')->paginate(20);
        return view('movies.index')->with('allMovies', $allMovies);
    }

    public function showCase(): View
    {
        $genres = Genre::orderBy('code')->paginate(10);
        return view('genres.showcase',['genres' => $genres]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(): View
    {
        $newGenre = new Genre();
        return view('genres.create')->withGenre($newGenre);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Genre::create($request->all());
        return redirect('movies/showcase');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        //
    }
}
