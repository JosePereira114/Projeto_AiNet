<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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
    public function seats():HasMany{
        return $this->hasMany(Seat::class);
    }
    public function screenings():HasMany{
        return $this->hasMany(Screening::class);
    }
    public function getPhotoFullUrlAttribute()
    {
        if ($this->photo_filename && Storage::exists("public/theaters/{$this->photo_filename}")) {
            return asset("storage/theaters/{$this->photo_filename}");
        } else {
            return asset("img/no_img.png");
        }
    }
}
