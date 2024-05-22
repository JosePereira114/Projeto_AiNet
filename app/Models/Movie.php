<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use app\Models\Genre;
use app\Models\Screaning;

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


    protected $keyType = 'int';

    public function getFileNameAttribute()
    {
        return strtoupper(trim($this->id));
    }

    public function getImageExistsAttribute()
    {
        return Storage::exists("public/posters/{$this->poster_filename}");
    }

    public function getImageUrlAttribute()
    {
        if ($this->imageExists) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            return asset("storage/posters/_no_poster_1.jpg");
        }
    }


    public function getPosterUrlAttribute(): string
    {
        return Storage::url('posters/' . $this->poster_filename);
    }

    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'id', 'id');
    }

    public function screening(): HasMany
    {
        return $this->hasMany(Screening::class, 'id', 'id');
    }
}
