<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;

class userController extends Controller
{

    public function __construct(){

        $this->middleware('permission:create_users')->only(['create', 'store']);
        $this->middleware('permission:read_users')->only(['index']);
        $this->middleware('permission:update_users')->only(['edit', 'update']);
        $this->middleware('permission:delete_users')->only(['destroy']);
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $roles = Role::all();

        $users = User::whenSearch(request()->search)->whenRole(request()->role_id)->whereRoleNot('super_admin')->paginate(2);

        return view('dashboard.users.index', compact('roles','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $roles = Role::RoleNotSearch(['super_admin','admin', 'user'])->get();

        return view('dashboard.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:5',
            'role_id'  => 'required|numeric',
        ]);

        $request->merge(['password'=>bcrypt($request->password)]);

        $user = User::create($request->all());

        $user->attachRoles(['admin', $request->role_id]);

        session()->flash('success','Data added successfully');

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user){
        
        $roles = Role::RoleNotSearch(['super_admin','admin','user'])->get();

        return view('dashboard.users.edit', compact(['user', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user){

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role_id'  => 'required|numeric',
        ]);

        $user->update($request->all());

        $user->syncRoles(['admin', $request->role_id]);

        session()->flash('success','Data added successfully');

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user){

        $user->delete();

        session()->flash('success','Data deleted successfully');

        return redirect()->route('dashboard.users.index');
    }
}
