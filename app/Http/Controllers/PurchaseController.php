<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Screening;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PurchaseController extends \Illuminate\Routing\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
    public function showHistoric($id){
        $purchases = Purchase::where('customer_id', $id)->orderBy('created_at', 'desc')->get();
        foreach($purchases as $purchase){
            $purchase->tickets = Ticket::where('purchase_id', $purchase->id)->get();
        }
        return view('purchases.historic', [ 'purchases' => $purchases,]);
    }
    public function getReceipt(Purchase $purchase){
        if($purchase->receipt_pdf_filename){
            return Storage::download('pdf_purchases/'.$purchase->receipt_pdf_filename);
        }
    }
    public function buy(Screening $screening)
    {
        // Obtenha os tickets associados ao screening específico
        $tickets = $screening->tickets;

        return view('tickets.buy', [
            'screening' => $screening,
            'tickets' => $tickets
        ]);
    }
}
