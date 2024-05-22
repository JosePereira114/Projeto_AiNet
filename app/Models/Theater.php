<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theater extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'name',
        'photo_filename',
        'custom',
    ];
    public $timestamps = false;
    public function seat():HasMany{
        return $this->hasMany(Seat::class);
    }
    public function screening():HasMany{
        return $this->hasMany(Screening::class);
    }
}
