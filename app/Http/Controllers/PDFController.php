<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    
    public static function generateReceipt(Purchase $purchase,$tickets)
    {
        $screenings=[];
        $seats=[];
        $screeningIds = []; 
        foreach($tickets as $t){
            $screening = \App\Models\Screening::find($t->screening_id);
            if ($screening && !in_array($screening->id, $screeningIds)) {
                $screenings[] = $screening;
                $seats[] = \App\Models\Seat::find($t->seat_id);
                $screeningIds[] = $screening->id; // Adicione o ID do screening ao array de IDs
            }
        }
            $data = [
            'date' => $purchase->date, 
            'total' => $purchase->total_price,
            'seats' => $seats, 
            'tickets' => $tickets,
            'screenings' => $screenings, 
            'user' => $purchase->customer_name, 
            'email' => $purchase->customer_email, 
            'created_at' => $purchase->created_at,
            'updated_at' => $purchase->updated_at,
            'id' => $purchase->id];  
        
        $pdf = PDF::loadView('pdf.document', $data); 
        // Definindo o nome do arquivo PDF, pode incluir mais dados como ID ou timestamp para diferenciar
        $filename = 'document_' . $purchase->id . '.pdf';
    
        // Salvando o PDF no storage (você pode ajustar o caminho conforme necessário)
        $pdf->save(storage_path('app/public/receipts/' . $filename));
        $pdf->stream('document_' . $purchase->id . '.pdf');
        // Retornando o nome do arquivo PDF
        return $filename;
    }

}
