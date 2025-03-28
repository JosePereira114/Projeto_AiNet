<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'type',
        'gender',
        'photo_filename'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getImageExistsAttribute()
    {
        return Storage::exists("public/photos/{$this->photo_filename}");
    }

    public function getFileNameAttribute()
    {
        return strtoupper(trim($this->photo_filename));
    }

    public function getImageUrlAttribute()
    {
        if ($this->photo_filename && Storage::exists("public/photos/{$this->photo_filename}")) {
            return asset("storage/photoss/{$this->photo_filename}");
        } else {
            return asset("storage/photos/anonymous.png");
        }
    }
    public function getPhotoFullUrlAttribute()
    {
        if ($this->photo_filename && Storage::exists("public/photos/{$this->photo_filename}")) {
            return asset("storage/photos/{$this->photo_filename}");
        } else {
            return asset("img/no_img.png");
        }
    }
    
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }
}
