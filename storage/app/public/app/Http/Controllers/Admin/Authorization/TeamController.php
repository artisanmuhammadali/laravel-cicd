<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Str;
use App\Jobs\AdminTeamRegisteredMailJob;

class TeamController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:Authorization']);
    }

    public function index()
    {
        $roles = Role::all();
        $users = User::whereHas('roles')->with('roles')->orderBy('id', 'desc')->get();
        return view('admin.authorization.teams.teams', get_defined_vars());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required'
        ]);

        $random_password = Str::random(10);

        $user = User::create([
            'first_name' => $request->name,
            'user_name'  => Str::random(10),
            'email' => $request->email,
            'role' => 'admin',
            'password' => Hash::make($random_password)
        ]);
        $user->assignRole($request->role);


        sendMail([

            'view' => 'email.admin.sub-admin',
            'to' => $user->email,
            'subject' => 'You have been Assigned a role at VFS',
            'data' => [
                'name'=> $user->first_name,
                'email'=> $user->email,
                'password'=> $random_password,
            ]
    ]);


        return redirect()->route('admin.teams.index')->with('message','Team Member has been created.');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function remove($id)
    {
        User::find($id)->delete();
        return back()->with('message','Team Member has been deleted.');
    }

}
