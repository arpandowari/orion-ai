<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'syllabus', 'thumbnail', 'is_active'];

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('order');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
