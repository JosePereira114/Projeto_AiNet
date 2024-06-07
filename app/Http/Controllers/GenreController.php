<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GenreFormRequest;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allGenres = Genre::orderBy('name')->paginate(20);
        return view('genres.index',compact('allGenres'));
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
        return view('genres.create')->with('genre',$newGenre);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenreFormRequest $request): RedirectResponse
    {
        $newGenre=Genre::create($request->validated());
        $url = route('genres.show', ['genre' => $newGenre]);
        $htmlMessage = "Genre <a href='$url'><u>{$newGenre->name}</u></a> has been created successfully!";
        return redirect()->route('genres.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre): View
    {
        return view('genres.show',compact('genre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('genres.edit',compact('genre'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(GenreFormRequest $request, Genre $genre): RedirectResponse
    {
        $genre->update($request->validated());
        $url = route('genres.show', ['genre' => $genre]);
        $htmlMessage = "Genre <a href='$url'><u>{$genre->name}</u></a> has been updated successfully!";
        $genre->save();
        return redirect()->route('genres.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        try{
            $url = route('genres.show', ['genre' => $genre]);
            $totalMovies = $genre->movies->count();
            if($totalMovies==0){
                $genre->delete();
                $allertType='success';
                $allertMsg = "Genre <a href='$url'><u>{$genre->name}</u></a> has been deleted successfully!";
            }else{
                $allertType='warning';
                $moviesStr = match(true){
                    $totalMovies<=0=>"",
                    $totalMovies==1=>"there is 1 movie enrolled in this genre",
                    $totalMovies> 1 =>"there are $totalMovies movies enrolled in this genre"
                };
                $justification = $moviesStr;
                $allertMsg="Genre <a href='$url'><u>{$genre->name}</u></a> could not be deleted because $justification.";
            }

        }catch(\Exception $e){
            $allertType='danger';
            $allertMsg = "It was not possible to delete the Genre
                          <a href='$url'><u>{$genre->name}</u></a>
                          because there was an error with the operation!.";
        }
        return redirect()->route('genres.index')
        ->with('alert-type', $allertType)
        ->with('alert-msg', $allertMsg);
    }
}
