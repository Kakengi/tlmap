<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Session;

class PermissionsController extends Controller
{
    
   public function index()
   {
       $permissions = Permission::paginate(10);
       return view('layouts.backend.users.permission_list',compact('permissions'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       return view('layouts.backend.users.permission_form');
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
           'name' =>'required',
           'display_name'=>'required'
       ]);
       if(Permission::where('name',$request->name)->exists()){
           Session::flash('error','The permission your trying to register already existing.');
           return redirect()->back();
       }
       else{
           Permission::create($request->all());
            Session::flash('success','Permission Created Successfully');
            return redirect()->route('permissions.index');
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
       //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit(Permission  $permission)
   {
       return view('layouts.backend.users.permission_form',compact('permission'));
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
       $permission = Permission::findorfail($id);
       $this->validate($request,[
           'name' =>'required',
           'display_name'=>'required'
       ]);

       $permission->update($request->all());
       Session::flash('success','Permission Updated Successfully');
       return redirect()->route('permissions.index');

   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $permission = Permission::findorfail($id);
       $permission->delete();

       Session::flash('error','Permission Deleted Successfully');
       return redirect()->route('permissions.index');
   }
}
