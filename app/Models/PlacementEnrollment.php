<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacementEnrollment extends Model
{
    protected $fillable = ['email', 'phone', 'amount', 'status'];
}
