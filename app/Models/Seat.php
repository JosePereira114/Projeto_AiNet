<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Seat extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'row',
        'seat_number',
        'custom',
    ];
    public $timestamps = false;
    public function tickets():HasMany{
        return $this->hasMany(Ticket::class);
    }
    public function theater():BelongsTo{
        return $this->belongsTo(Theater::class)->withTrashed();
    }
}
