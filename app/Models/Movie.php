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

    public function getImageExistsAttribute()
    {
        return Storage::exists("public/posters/{$this->fileName}");
    }

    public function getImageUrlAttribute()
    {
        if ($this->imageExists) {
            return asset("storage/posters/{$this->fileName}");
        } else {
            return asset("storage/posters/_no_poster_1.jpg");
        }
    }
    

    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_code', 'id');
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class, 'movie_id', 'id');
    }
}
