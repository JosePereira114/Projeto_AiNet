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
        $purchases = Purchase::orderBy('created_at', 'desc')->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return view('purchases.show', compact('purchase'));
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        try {
        $purchase->delete();
        return redirect()->route('purchases.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Purchase deleted successfully');
    } catch (\Exception $e) {
        return redirect()->route('purchases.index')
            ->with('alert-type', 'danger')
            ->with('alert-msg', 'Error deleting purchase');
    }
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
