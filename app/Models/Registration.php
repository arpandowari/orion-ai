<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Registration extends Authenticatable
{
    protected $fillable = [
        'course_id', 'name', 'email', 'password', 'profile_picture', 'cgpa', 'education_details',
        'internship_experience', 'extracurricular_activities', 'goal',
        'suitable_role', 'expected_ctc', 'resume_path', 'marksheet_path',
        'status', 'course_unlocked'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'internship_experience' => 'array',
        'course_unlocked' => 'boolean',
        'password' => 'hashed',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    // Override the default auth identifier name
    public function getAuthIdentifierName()
    {
        return 'id';
    }
    
    // Override the default auth password name
    public function getAuthPassword()
    {
        return $this->password;
    }
}
