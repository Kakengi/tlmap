<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Session;

class RolesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('layouts.backend.users.all_roles',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('layouts.backend.users.role_form',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'display_name' => 'required',
        
        ]);
        if(Role::where('name',$request->name)->exists()){
            Session::flash('error','The role your trying to register already existing.');
            return redirect()->back();
        }
        else{
            Role::create($request->all());
             Session::flash('success','Role Created Successfully');
             return redirect()->route('roles.index');
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findorfail($id);
        $permissions = Permission::all();
        return view('layouts.backend.users.role_show',compact('role','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('layouts.backend.users.role_form',compact('permissions','role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findorfail($id);
        $this->validate($request,[
            'name' => 'required',
            'display_name' => 'required',
        
        ]);

        $role->update($request->all());
        Session::flash('success','Role Updated Successfully');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findorfail($id);
        $role->delete();

        Session::flash('error','Role Deleted Successfully');
        return redirect()->route('roles.index');
    }
}
