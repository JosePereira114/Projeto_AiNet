<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Customer;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use app\Models\Ticket;
use Illuminate\Support\Facades\Storage;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'movie_id',
        'total_price',
        'customer_name',
        'customer_email',
        'nif',
        'payment_type',
        'payment_ref',
        'receipt_pdf_filename',
        'custom',
        'created_at',
        'updated_at',
    ];
    public function costumer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'id')->withTrashed();
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'id', 'id');
    }
    public function getReceiptFullUrlAttribute(){
        if($this->receipt_pdf_filename && Storage::exists('receipts/' . $this->receipt_pdf_filename)){
            return route('purchase.receipt');
        }else{
            return null;
        }
    }
}
