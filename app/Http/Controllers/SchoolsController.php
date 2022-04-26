<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use App\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Session;

class SchoolsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
                      $model = School::with('ward');
                          return DataTables::eloquent($model)
                          ->addIndexColumn()
                        //   ->addColumn('regions', function (School $school) {
                        //     return $school->wards->districts->regions->name;
                        //  })
                        ->addColumn('regions', function ($school) {
                            return optional(optional(optional($school->ward)->district)->region)->name;
                           //return $school->ward;
                          })
                         ->addColumn('districts', function ($school) {
                           return optional(optional($school->ward)->district)->name;
                          //return $school->ward;
                         })
                         ->addColumn('wards', function ($school) {
                            return optional($school->ward)->name;
                         })
                          ->addColumn('action', function($row){
                              $actionBtn = '   <a title="Update school information" class="btn btn-xs btn-success" href=""><i class="fa fa-undo"></i></a> ';
                              return $actionBtn;     
                          })     
                          ->rawColumns(['action'])    
                          ->make(true);       
                 }
            
                   return view('layouts.backend.schools.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
