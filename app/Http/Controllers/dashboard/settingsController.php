<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class settingsController extends Controller
{

    public function __construct(){

        $this->middleware('permission:create_settings')->only(['social_links', 'social_login', 'store']);
        $this->middleware('permission:read_settings')->only(['social_links', 'social_login']);

    }


    public function social_links(){

        return view('dashboard.settings.social_links');
    }

    public function social_login(){

        return view('dashboard.settings.social_login');
    }

    public function store(Request $request){

        // this function will save data at setting file .json in the Storage Director

        setting($request->all())->save();

        session()->flash('success','Data added successfully');

        return redirect()->back();
    }
}
