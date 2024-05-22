<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use app\Models\Genre;
use app\Models\Screaning;

class Movie extends Model
{
    use HasFactory;
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
        return strtoupper(trim($this->abbreviation)) . '.png';
    }

    public function getImageExistsAttribute()
    {
        return Storage::exists("public/courses/{$this->fileName}");
    }

    public function getImageUrlAttribute()
    {
        if ($this->imageExists) {
            return asset("storage/courses/{$this->fileName}");
        } else {
            return asset("storage/courses/no_course.png");
        }
    }

    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'id', 'id');
    }

    public function disciplines(): HasMany
    {
        return $this->hasMany(Screaning::class, 'id', 'id');
    }
}
