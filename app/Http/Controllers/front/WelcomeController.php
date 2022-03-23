<?php

namespace App\Http\Controllers\front;

use App\category;
use App\Http\Controllers\Controller;
use App\Movie;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){

        $movies = Movie::latest()->take(5)->where('percent', 100)->get();
        $categories = category::whereHas('movies')->get();


        return view('front.welcome', compact('movies', 'categories'));
    }
}
