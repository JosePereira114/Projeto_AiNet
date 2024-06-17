<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'custom',
        'deleted_at',
    ];
    public $timestamps = false;
    public $primaryKey = 'code';
    public $incrementing = false;

    public $keyType = 'string';
    public function movies():HasMany
    {
        return $this->hasMany(Movie::class, 'genre_code', 'code');
    }
    public function screenings():HasManyThrough{
        return $this->hasManyThrough(Screening::class, Movie::class,'genre_code','movie_id','code','id');
    }
}
