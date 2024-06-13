<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screening;

class TicketController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::orderBy('created_at', 'desc')->paginate(10);
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticket = new Ticket();
        return view('tickets.create', compact('ticket'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newTicket = Ticket::create($request->validated());
        $url = route('tickets.show', ['ticket' => $newTicket]);
        $htmlMessage = "Ticket <a href='$url'><u>{$newTicket->name}</u></a> has been created successfully!";
        return redirect()->route('tickets.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function validate(Request $request)
    {
        //validar o ticket
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        $url = route('tickets.show', ['ticket' => $ticket]);
        $htmlMessage = "Ticket <a href='$url'><u>{$ticket->name}</u></a> has been updated successfully!";
        return redirect()->route('tickets.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        try {
            $url = route('tickets.show', ['ticket' => $ticket]);
            $totalPurchase = $ticket->purchase()->count();
            $totalSeat = $ticket->seat()->count();
            $totalScreening = $ticket->screening()->count();
            if ($totalPurchase || $totalSeat || $totalScreening) {
                $htmlMessage = "Ticket <a href='$url'><u>{$ticket->name}</u></a> cannot be deleted because it is associated with a purchase, seat or screening";
                return redirect()->route('tickets.index')
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', $htmlMessage);
            } else {
                $ticket->delete();
                $htmlMessage = "Ticket <a href='$url'><u>{$ticket->name}</u></a> has been deleted successfully!";
                return redirect()->route('tickets.index')
                    ->with('alert-type', 'success')
                    ->with('alert-msg', $htmlMessage);
            }
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')
                ->with('alert-type', 'danger')
                ->with('alert-msg', 'Ticket cannot be deleted');
        }
    }
}
