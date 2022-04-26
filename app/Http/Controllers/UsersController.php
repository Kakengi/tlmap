<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$users = User::all();
        if ($request->ajax()) {
            $model = User::withTrashed('*');
            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('role', function ($user) {
                    return view('layouts.backend.users.includes.roles', compact('user'));
                })
                ->addColumn('full_name', function ($user) {
                    return $user->full_name;
                })
                ->addColumn('action', function ($user) {
                    return view('layouts.backend.users.includes.actions', compact('user'));
                })
                ->rawColumns(['action'])
                ->setRowClass(function ($user) {
                    return $user->deleted_at ? 'text-danger' : ($user->is_ban ? 'text-war ning' : '');
                })
                ->setRowAttr([
                    'title' => function ($user) {
                        return $user->deleted_at ? 'This user is deleted.' : ($user->is_ban ? 'This user is banned.' : '');
                    }
                ])
                ->make(true);
        }
        return view('layouts.backend.users.users_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $current_verified_at = Carbon::now()->toDateTimeString();
        return view('layouts.backend.users.form', compact('roles', 'current_verified_at'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'second_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'email_verified_at' => 'required',
            'is_ban' => 'required',
            'roles[]' => 'required',
            // 'phone_number'=>'required',
        ]);



        $hash_password = Hash::make($request->password);
        // $avatar_path = 'uploads/avatars/default_avatar.png';
        $request['password'] = $hash_password;
        // $request['avatar'] = $avatar_path;
        //$request['isBan'] = 0;
        // $request['email_verified_at'] = $current_verified_at;
        //dd($request->all());
        $user = new User();
        $user->first_name = $request->first_name;
        $user->second_name = $request->second_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->sex = $request->sex;
        $user->phone_number = $request->first_name;
        $user->email_verified_at = $request->email_verified_at;
        $user->isBan = $request->isBan;
        $user->password = $hash_password;
        $user->isBan = $request->isBan;
        $user->save();
        // $user = User::create($request->all());
        $user->roles()->attach($request->roles);
        Session::flash('success', 'User Created Successfully');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('layouts.backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User  $user)
    {
        return $this->create()->with([
            'edit' => true,
            'editedUser' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->has('renew_password')) {
            $password_hash = Hash::make($request->password);
            $user->password = $password_hash;
            // $user->isBan = $request->isBan; 
        }

        $user->update();
        $user->roles()->sync($request->roles);
        Session::flash('success', 'User Updated Successfully');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        Session::flash('error', 'User Deleted Successfully');
        return redirect()->route('users.index');
    }

    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $baned = $user->update([
            'is_ban' => 1
        ]);

        if ($baned) {
            Session::flash('error', 'User is banned successfully' . " " . $user->first_name . " " . $user->last_name . " " . "Will not be allowed to use this system");
        }
        return back();
    }
    /**
     * 
     */
    public function unBanUser($id)
    {
        $user = User::findOrFail($id);
        $unbaned = $user->update([
            'is_ban' => 0
        ]);
        if ($unbaned) {
            Session::flash('success', 'User ban is revoked successfully ' . " " . $user->first_name . " " . $user->last_name . " " . "Will now be allowed to use this system");
        }
        return back();
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findorfail($id);
        $user->deleted_at = NULL;
        $user->update();
        Session::flash('success', 'User Un-Deleted successfully ' . " " . $user->first_name . " " . $user->last_name . " " . "Will now be allowed to use this system");
        return back();
    }
}
