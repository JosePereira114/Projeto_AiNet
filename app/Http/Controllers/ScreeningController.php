<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ScreeningFormRequest;
use Illuminate\View\View;

class ScreeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $screenings = Screening::orderBy('id', 'desc')->paginate(20);
        return view('screenings.index')->with('screenings', $screenings);
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
    public function store(ScreeningFormRequest $request)
    {
        // Valida os dados do request
        $validatedData = $request->validated();

        // Inclui o campo 'date' no array de dados a serem criados
        $validatedData['date'] = $request->input('date'); // Substitua 'date' pelo nome correto do campo

        // Cria um novo Screening com os dados validados
        $newScreening = Screening::create($validatedData);

        // Gera a URL para a página de visualização do screening criado
        $url = route('screenings.show', ['screening' => $newScreening]);

        // Mensagem HTML de sucesso
        $htmlMessage = "Screening <a href='$url'><u>{$newScreening->screening_time}</u></a> has been created successfully!";

        // Redireciona para a página de índice de screenings com uma mensagem de sucesso
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
