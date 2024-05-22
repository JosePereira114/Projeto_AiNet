<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screening extends Model
{
    use HasFactory;
    protected $fillable=[
        'start_time',
        'end_time',
        'movie_id',
        'theater_id',
        'custom',
    ];
    public function tickets():HasMany{
        return $this->hasMany(Ticket::class);
    }
    public function theater():BelongsTo{
        return $this->belongsTo(Theater::class)->withTrashed();
    }
    public function movie():BelongsTo{
        return $this->belongsTo(Movie::class)->withTrashed();
    }
}
