<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable=[
        'price',
        'qrcode_url',
        'status',
        'created_at',
        'updated_at',
    ];
    public function purchase():BelongsTo{
        return $this->belongsTo(Purchase::class);
    }
    public function seat():BelongsTo{
        return $this->belongsTo(Seat::class)->withTrashed();
    }
    public function screening():BelongsTo{
        return $this->belongsTo(Screening::class);
    }
}
