<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use App\Models\Genre;
use App\Models\Screening;

class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'genre_code',
        'year',
        'poster_filename',
        'synopsis',
        'trailer_url',
        'created_at',
        'updated_at',
        'deleted_at',
    ];



    public function getFileNameAttribute()
    {
        return strtoupper(trim($this->poster_filename));
    }

    public function getImageUrlAttribute()
    {
        if ($this->poster_filename && Storage::exists("public/posters/{$this->poster_filename}")) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            return asset("storage/posters/_no_poster_1.png");
        }
    }

    

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_code', 'id');
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class, 'movie_id', 'id');
    }
}
