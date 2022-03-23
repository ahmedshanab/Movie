<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile(){
        return view('front.profile.edit');
    }

    public function updateProfile(Request $request){

        $update = User::FindOrFail(auth()->user()->id);

        $request->validate([
            'email' => 'email|unique:users,email,' . auth()->user()->id,
            'name' => 'string',
        ]);

        $update->update([
            'bio' => $request->bio,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if($request->bio){

            $request->validate([
                'bio' => 'string',
            ]);

            $update->update([
                'bio' => $request->bio,
                ]);

        }
        if($request->file('avatar')){

            $request->validate([
                'avatar' => 'image',
            ]);

            if($update->avatar != 'public/profiles/avatar/default.jpg'){
                Storage::disk('local')->delete($update->avatar);
            }

            $update->update([
                'avatar' => $request->file('avatar')->store('public/profiles/avatar'),
            ]);

        }

        if($request->password){

            $request->validate([
                'password' => 'min:7|confirmed',
            ]);

            $update->update([
                'password' => bcrypt($request->password),
            ]);
        }

        session()->flash('success','Profile updated successfully');

        return redirect(route('profile.edit'));
    }
}
