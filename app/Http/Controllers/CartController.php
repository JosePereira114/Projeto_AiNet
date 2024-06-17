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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

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
        $seats = $request->seats ?? [];
        $seats_adicionados = [];
        foreach ($seats as $seat_id) {
            $id = $screening->id . '_' . $seat_id;
            if (!array_key_exists($id, $cart)) {
                $seat = Seat::findOrFail($seat_id);
                $cart[$id] = ["screening" => $screening, "seat" => $seat];
                $seats_adicionados[] = $seat->row . $seat->seat_number;
            }
        }
        if ($seats_adicionados) {
            session(['cart' => $cart]);
            $allertType = 'success';
            $htmlMessage = "Seats <strong>" . implode(", ", $seats_adicionados) . "</strong> were added to the cart.";
        } else {
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
        if (count($cart) == 0) {
            $alertType = 'warning';
            $htmlMessage = "No seats were removed from the cart.";
        } else {
            if (!array_key_exists($id, $cart)) {
                $alertType = 'warning';
                $htmlMessage = "Seat was not removed from the cart.";
            } else {
                $alertType = 'success';
                $htmlMessage = "Seat " . $cart[$id]['seat']->row . $cart[$id]['seat']->seat_number . " was removed from the cart.";
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
            $purchase->customer_id = Auth::user() ? Auth::user()->id : null;
            $purchase->date = Carbon::now();
            $ignored = 0;
            $configuration = Configuration::first();
            $basicPrice = $configuration->ticket_price;
            $totalPrice = 0;
            $insertTickets = [];
            $totalPrice = 0; // Initialize the $totalPrice variable
            $pdfPath = '';
            foreach ($cart as $item) {
                $screening = $item['screening'];
                $seat = $item['seat'];

                $noTickets = $screening->tickets()->where('seat_id', $seat)->count() == 0;
                $isFutureDate = $screening->date > Carbon::today()->format('Y-m-d');
                $isTodayAndValidTime = $screening->date == Carbon::today()->format('Y-m-d') && $screening->start_time >= Carbon::now()->addMinutes(5)->format('H:i:s');

                if ($noTickets && ($isFutureDate || $isTodayAndValidTime)) {
                    $price = Auth::user() ? $basicPrice - $configuration->registered_customer_ticket_discount : $basicPrice;
                    $insertTickets[] = [
                        'screening_id' => $item['screening']->id,
                        'seat_id' => $item['seat']->id,
                        'price' => $price,
                    ];
                } else {
                    $ignored++;
                }
            }
            $ignoredStr = match ($ignored) {
                0 => "",
                1 => "1 ticket was ignored because the screening has already started.",
                default => "$ignored tickets were ignored because the screening has already started."
            };
            $totalInserted = count($insertTickets);
            $totalInsertedStr = match ($totalInserted) {
                0 => "No tickets were inserted.",
                1 => "1 ticket was inserted.",
                default => "$totalInserted tickets were inserted."
            };
            if ($totalInserted == 0) {
                $request->session()->forget('cart');
                return back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', "Cart was not confirmed, because all tickets were ignored.");
            } else {
                DB::transaction(function () use ($purchase, $insertTickets, $totalPrice, &$pdfPath) {
                    $purchase->total_price = $totalPrice;
                    $purchase->save();
                    foreach ($insertTickets as $t) {
                        $ticket = new Ticket();
                        $ticket->fill($t);
                        $ticket->purchase_id = $purchase->id;
                        $ticket->screening_id = $t['screening_id'];
                        $ticket->seat_id = $t['seat_id'];
                        $randomString = Str::random(64);
                        $ticket->save();
                        $ticketUrl = route('tickets.showcase', ['ticket' => $ticket, 'qrcode_url' => $randomString]);
                        $ticket->qrcode_url = $randomString;
                        $ticket->save();
                        $totalPrice += $t['price'];
                        $tickets[] = $ticket;
                    }
                    $purchase->total_price = $totalPrice;
                    $purchase->save();
                    $pdfData = PDFController::generateReceipt($purchase, $tickets);
                    $purchase->receipt_pdf_filename = $pdfData['filename'];
                    $purchase->save();
                    $pdfPath = public_path('storage/receipts/' . $pdfData['filename']);
                });
                $request->session()->forget('cart');
                $request->session()->put('pdf-Path', $pdfPath);
            }
        }
        if ($ignored == 0) {
            return redirect()->route('home')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Cart was confirmed. $totalInsertedStr")
                ->with('pdf-path',$pdfPath);
        } else {
            return redirect()->route('home')
                ->with('alert-type', 'warning')
                ->with('alert-msg', "Cart was confirmed. $totalInsertedStr $ignoredStr");
        }
    }
    public function downloadPdf(Request $request)
    {
        $pdfPath = $request->session()->get('pdfPath');

        if (!$pdfPath || !file_exists($pdfPath)) {
            return redirect()->route('home')
                ->with('alert-type', 'danger')
                ->with('alert-msg', 'Failed to download the receipt PDF.');
        }

        // Remova o arquivo após o envio
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
