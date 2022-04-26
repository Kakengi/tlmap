<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Region;
use App\Models\District;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Supplier::withTrashed('user')
                ->with('district')
                ->with('region');
            return DataTables::eloquent($model)
                ->addColumn('user', function (Supplier $supplier) {
                    return $supplier->user->first_name . " " . $supplier->user->last_name;
                })
                ->addColumn('region', function (Supplier $supplier) {
                    return optional($supplier->region)->name;
                    //return $school->ward;
                })
                ->addColumn('district', function (Supplier $supplier) {
                    return optional($supplier->district)->name;
                    //return $school->ward;
                })
                ->addColumn('action', function ($supplier) {
                    return view('layouts.backend.suppliers.includes.actions', [
                        'supplier' => $supplier
                    ]);

                    // return view('actions.actions', [
                    //     'btn_show_type' => 'btn-outline-success',
                    //     'btn_edit_type' => 'btn-outline-primary',
                    //     'btn_delete_type' => 'btn-outline-danger',
                    //     'btn_right_space' => 'mr-2',
                    //     // 'is_deleted' => $supplier->deleted_at,
                    //     'btn_show' => false,
                    //     'btn_edit' => true,
                    //     'btn_delete' => true,
                    //     'btn_restore' => false,
                    //     'show_link' => route('suppliers.show', $supplier->id),
                    //     'edit_link' => route('suppliers.edit', $supplier->id),
                    //     'delete_link' => route('suppliers.destroy', $supplier->id)
                    //     // 'restore_link' => route('suppliers.restore', $supplier->id)
                    // ]);
                })
                ->setRowClass(function ($supplier) {
                    return $supplier->deleted_at ? 'text-danger' :  '';
                })
                ->rawColumns(['action'])
                ->make(true);

            //->toJson();
        }
        return view('layouts.backend.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::all();
        return view('layouts.backend.suppliers.form', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function GetDistrictsId($id)
    {
        echo json_encode(District::selectRaw('id,name')->where('region_id', $id)->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:suppliers',
            'email' => 'required|unique:suppliers',
            'phone_number' => 'unique:suppliers|regex:/(255)[0-9]{9}/',
            'district_id' => 'required',
            'region_id' => 'required',
            'address' => 'required'

        ]);

        $request['created_by'] = auth()->user()->id;
        $supplier = Supplier::create($request->all());

        Session::flash('success', 'Supplier' . " " . $supplier->name . " " . "Created Successfully");
        return redirect()->route('suppliers.index');
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
    public function edit(Supplier $supplier)
    {
        $supplier_districts = $supplier->region_id;
        //$wards_districts = $center->district_id;

        $region_districts = District::where('region_id', $supplier_districts)->get();
        $regions = Region::all();
        return view('layouts.backend.suppliers.form', compact('regions', 'supplier', 'region_districts'));
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
        $supplier = Supplier::findorfail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'unique:users|regex:/(255)[0-9]{9}/',
            'district_id' => 'required',
            'region_id' => 'required',
            'address' => 'required'

        ]);
        //dd($supplier);
        $supplier->update($request->all());
        Session::flash('success', 'Supplier' . " " . $supplier->name . " " . "Updated Successfully");
        return redirect()->route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        Session::flash('error', 'Supplier Deleted Successfully');
        return redirect()->route('suppliers.index');
    }

    public function unDelete($id)
    {
        $supplier = Supplier::withTrashed()->findorfail($id);
        $supplier->deleted_at = NULL;
        //dd($supplier);
        $supplier->update();
        Session::flash('success', 'Supplier User Un-Deleted  Successfully');
        return redirect()->route('suppliers.index');
    }
}
