<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PDFController extends Controller
{
    
    public static function generateReceipt(Purchase $purchase,$tickets)
    {
        $screenings=[];
        $seats=[];
        $screeningIds = []; 
        $qrCodes = [];
        foreach($tickets as $t){
            $screening = \App\Models\Screening::find($t->screening_id);
            if ($screening && !in_array($screening->id, $screeningIds)) {
                $screenings[] = $screening;
                $screeningIds[] = $screening->id;
                
            }
            
            $seats[] = \App\Models\Seat::find($t->seat_id);
            $url = route('tickets.showcase', ['ticket' => $t->id, 'qrcode_url' => $t->qrcode_url]);
            $qrCode = QrCode::format('png')->size(300)->generate($url);
            $qrCodes[$t->id] = base64_encode($qrCode);
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
            'id' => $purchase->id,
            'qrcodes' => $qrCodes,
        ];  
        
        $pdf = PDF::loadView('pdf.document', $data); 
        // Definindo o nome do arquivo PDF, pode incluir mais dados como ID ou timestamp para diferenciar
        $filename = 'document_' . $purchase->id . '.pdf';
    
        // Salvando o PDF no storage (você pode ajustar o caminho conforme necessário)
        $pdfPath=storage_path('app/public/receipts/' . $filename);
        $pdf->save($pdfPath);
        $pdf->stream('document_' . $purchase->id . '.pdf');
        $pdf->download($pdfPath);
        // Retornando o nome do arquivo PDF
        return ['filename' => $filename, 'base64' => base64_encode(file_get_contents($pdfPath))];
    }

}
