<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'abbreviation',
        'name',
        'name_pt',
        'type',
        'semesters',
        'ECTS',
        'places',
        'contact',
        'objectives',
        'objectives_pt',
    ];

    public $timestamps = false;

    protected $primaryKey = 'abbreviation';

    public $incrementing = false;

    protected $keyType = 'string';

    public function getFullNameAttribute()
    {
        return match ($this->type) {
            'Master'    => "Master's in ",
            'TESP'      => 'TeSP - ',
            default     => ''
        }
            . $this->name;
    }

    public function getImageUrlAttribute()
    {
        $abrUpper = strtoupper(trim($this->abbreviation));
        if (Storage::exists("public/courses/$abrUpper.png")) {
            return asset("storage/courses/$abrUpper.png");
        } else {
            return asset("storage/courses/no_course.png");
        }
    }
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'course', 'abbreviation');
    }
    public function disciplines(): HasMany
    {
        return $this->hasMany(Discipline::class, 'course', 'abbreviation');
    }
}
