<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TheaterFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TheaterController extends Controller
{
    /**
     * Display a listing of the resource.
        */

    public function index(Request $request): View
    {
        $theaters = Theater::paginate(10);
        return view(
            'theaters.index',
            compact('theaters')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $theater = new Theater();
        // $courses no longer required, because it is available through View::share
        // Check AppServiceProvider
        //$courses = Course::all();
        return view('theaters.create', compact('theater'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function  store(TheaterFormRequest $request): RedirectResponse
    {
        $newTheater = Theater::create($request->validated());
        if ($request->hasFile('photo_file')) {
            $path = $request->photo_file->store('public/theaters');
            $newTheater->photo_filename = basename($path);
            $newTheater->save();
        }
        $url = route('theaters.show', ['theater' => $newTheater]);
        $htmlMessage = "Theater <a href='$url'><u>{$newTheater->name}</u></a> has been created successfully!";
        return redirect()->route('theaters.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }


    /**
     * Display the specified resource.
     */
    public function show(Theater $theater): View
    {
        return view('theaters.show',compact('theater'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theater $theater): View
    {
        return view('theaters.edit',compact('theater'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TheaterFormRequest $request, Theater $theater): RedirectResponse
    {
        $theater->update($request->validated());
        $url = route('theaters.show', ['theater' => $theater]);
        $htmlMessage = "Theater <a href='$url'><u>{$theater->name}</u></a> has been updated successfully!";
        if ($request->hasFile('photo_file')) {
            // Delete previous file (if any)
            if ($theater->photo_filename &&
                Storage::fileExists('public/theater/' . $theater->photo_filename)) {
                    Storage::delete('public/theater/' . $theater->photo_filename);
            }
            $path = $request->photo_file->store('public/theater');
            $theater->photo_filename = basename($path);
            $theater->save();
        }
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theater $theater): RedirectResponse
    {
        try {
            $url = route('theaters.show', ['theater' => $theater]);
            $totalScreenings = $theater->screenings()->count();
            $totalSeats = $theater->seats()->count();
            if ($totalScreenings == 0 && $totalSeats == 0) {
                $theater->delete();
                $alertType = 'success';
                $alertMsg = "Theater {$theater->name}  has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $screeningsStr = match (true) {
                    $totalScreenings <= 0 => "",
                    $totalScreenings == 1 => "there is 1 student enrolled in it",
                    $totalScreenings > 1 => "there are $totalScreenings students enrolled in it",
                };
                $seatsStr = match (true) {
                    $totalSeats <= 0 => "",
                    $totalSeats == 1 => "it already has 1 teacher",
                    $totalSeats > 1 => "it already has $totalSeats teachers",
                };
                $justification = $screeningsStr && $seatsStr
                    ? "$screeningsStr and $seatsStr"
                    : "$screeningsStr$seatsStr";
                $alertMsg = "Theater <a href='$url'><u>{$theater->name}</u></a>  cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Theater
                            <a href='$url'><u>{$theater->name}</u></a> 
                            because there was an error with the operation!";
        }
        return redirect()->route('theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
    public function destroyPhoto(Theater $theater): RedirectResponse{
        if ($theater->photo_filename) {
            if (Storage::fileExists('public/theater/' . $theater->photo_filename)) {
                Storage::delete('public/theater/' . $theater->photo_filename);
            }
            $theater->photo_filename = null;
            $theater->save();
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Photo of teacher {$theater->name} has been deleted.");
        }
        return redirect()->back();
    }
}
