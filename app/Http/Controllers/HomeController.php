<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_active', true)->get();
        return view('home', compact('courses'));
    }
}
