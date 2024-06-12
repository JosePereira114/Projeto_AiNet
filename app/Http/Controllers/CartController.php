<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartConfirmationFormRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Discipline;
use App\Models\Seat;
use App\Models\Student;
use App\Models\Screening;
use App\Models\Purchase;
use App\Models\Configuration;
use App\Http\Controllers\PDFController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', null);
        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request, Screening $screening): RedirectResponse
    {
        $cart = session('cart', []);
        $seats = $request->seats??[];
        $seats_adicionados = [];
       foreach($seats as $seat_id){
            $id=$screening->id . '_' . $seat_id;
            if(!array_key_exists($id, $cart)){
                $seat=Seat::findOrFail($seat_id);
                $cart[$id]=["screening" => $screening, "seat" => $seat];
                $seats_adicionados[]=$seat->row . $seat->seat_number;
            }
       }
       if($seats_adicionados){
            session(['cart' => $cart]);
            $allertType = 'success';
            $htmlMessage = "Seats <strong>" . implode(", ", $seats_adicionados) . "</strong> were added to the cart.";
       }else{
            $allertType = 'warning';
            $htmlMessage = "No seats were added to the cart.";
       }
       return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $allertType);
    }

    public function removeFromCart(Request $request,  $id): RedirectResponse
    {
        $cart = session('cart', []);
        if(count($cart)==0){
            $alertType = 'warning';
            $htmlMessage = "No seats were removed from the cart.";
        }else{
            if(!array_key_exists($id, $cart)){
                $alertType = 'warning';
                $htmlMessage = "Seat was not removed from the cart.";
            }else{
                $alertType = 'success';
                $htmlMessage = "Seat ".$cart["id"]["seat"]->row.$cart." was removed from the cart.";
                unset($cart[$id]);
                session(['cart' => $cart]);
            }
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shopping Cart has been cleared');
    }


    public function confirm(CartConfirmationFormRequest $request): RedirectResponse
    {
        $cart = session('cart', []);
        if (!$cart || (count($cart) == 0)) {
            return back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Cart was not confirmed, because cart is empty!");
        } else {
            $purchase = new Purchase();
            $purchase->fill($request->validated());
            $purchase->customer_id = Auth::user()?Auth::user()->id:null;
            $purchase->date=Carbon::now();
            $ignored=0;
            $configuration=Configuration::first();
            $basicPrice=$configuration->ticket_price;
            $totalPrice=0;
            $totalPrice = 0; // Initialize the $totalPrice variable
            foreach($cart as $item){
                if($item['screening']->tickets()->where('seat_id',$item['seat'])->count()==0&&$item['screening']->date>Carbon::today()||$item['screening']->date== Carbon::today()&&$item['screening']->time>=Carbon::now()->addMinutes(5)->format('H:i:s')){
                    $price = Auth::user() ? $basicPrice - $configuration->registered_customer_ticket_discount : $basicPrice;
                    $insertTickets[]=['screening_id'=>$item['screening']->id, 
                    'seat_id'=>$item['seat']->id, 
                    'price'=>$price,];
                }else{
                    $ignored++;
                }
            }
            $ignoredStr = match($ignored){
                0=>"",
                1=>"1 ticket was ignored because the screening has already started.",
                default=>"$ignored tickets were ignored because the screening has already started."
            };
            $totalInserted = count($insertTickets);
            $totalInsertedStr = match($totalInserted){
                0=>"No tickets were inserted.",
                1=>"1 ticket was inserted.",
                default=>"$totalInserted tickets were inserted."
            };
            if($totalInserted==0){
                $request->session()->forget('cart');
                return back()
                        ->with('alert-type', 'danger')
                        ->with('alert-msg', "Cart was not confirmed, because all tickets were ignored.");
            }else{
                DB::transaction(function() use ($purchase, $insertTickets,$totalPrice){
                    $purchase->total_price=$totalPrice;
                    $purchase->save();
                    foreach($insertTickets as $t){
                        $ticket= new Ticket();
                        $ticket->fill($t);
                        $ticket->purchase_id=$purchase->id;
                        $ticket->qrcode_url=route('tickets.showcase',['ticket'=>$ticket]);
                        $ticket->save();
                    }
                    $purchase->receipt_pdf_filename=PDFController::generateReceipt($purchase);
                    $purchase->save();
                });
            }
        }
        if($ignored==0){
            return redirect()->route('home')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Cart was confirmed. $totalInsertedStr");
        }else{
            return redirect()->route('home')
                ->with('alert-type', 'warning')
                ->with('alert-msg', "Cart was confirmed. $totalInsertedStr $ignoredStr");
        }
    }
}
