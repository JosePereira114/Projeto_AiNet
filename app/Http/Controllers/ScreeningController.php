<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScreaningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filterByMovie = $request->query('movie');
        if($filterByMovie !== null){
            $screenings = Screening::where('movie_id', $filterByMovie)->orderBy('screening_time')->paginate(20);
        }
        return view(
            'screenings.index',
            compact('screenings', 'filterByMovie')
        );

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $screening = new Screening();
        return view('screenings.create')->with('screening', $screening);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newScreening = Screening::create($request->all());
        $url = route('screenings.show', ['screening' => $newScreening]);
        $htmlMessage = "Screening <a href='$url'><u>{$newScreening->screening_time}</u></a> has been created successfully!";
        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Screening $screening)
    {
        return view('screenings.show')
            ->with('screening', $screening);
    }
    public function showMoment($movieId): View
    {
        $screenings = Screening::where('movie_id', $movieId)->get();
        return view('movies.showmoment', ['screenings' => $screenings]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screening $screening)
    {
        return view('screenings.edit')->with('screening', $screening);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Screening $screening)
    {
        $screening->update($request->all());
        $url = route('screenings.show', ['screening' => $screening]);
        $htmlMessage = "Screening <a href='$url'><u>{$screening->screening_time}</u></a> has been updated successfully!";
        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening)
    {
        //
    }
}
