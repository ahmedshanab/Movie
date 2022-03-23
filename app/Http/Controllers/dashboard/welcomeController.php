<?php

namespace App\Http\Controllers\dashboard;

use App\category;
use App\Http\Controllers\Controller;
use App\Movie;
use App\User;
use Illuminate\Http\Request;

class welcomeController extends Controller
{
    public function index(){

        $users_count = User::whereRole('user')->count();
        $categories_count = category::count();
        $movies_count = Movie::where('percent', 100)->count();

        return view("dashboard.welcome", compact('users_count','categories_count', 'movies_count'));
    }


}
