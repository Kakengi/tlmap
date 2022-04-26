<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Receipt;
use App\Models\Supplier;
use App\Models\Supply;
use App\Models\SupplyHistory;
use App\Models\Publication;
use DB;
use Session;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $contract_suppliers = Contract::select('contracts.id as contract_identifier','suppliers.name', 'suppliers.id AS supplier_identifier','contracts.contract_title','contracts.contract_number','receipts.id')
        //     ->leftJoin("suppliers", 'suppliers.id', "=", 'contracts.supplier_id')
        //     ->leftJoin('receipts','receipts.contract_id','=','contracts.id')
        //    // ->leftJoin('publication_contract','publication_contract.publication_id','=','contracts.id')
        //     ->where('contract_status', 'active')->get();
        $receipt_publication = DB::table('publication_contract')
        ->leftJoin("publications", 'publications.id', "=", 'publication_contract.publication_id')
        ->leftJoin("contracts", 'contracts.id', "=", 'publication_contract.contract_id')
        ->select('contracts.id AS contract_identifier','contracts.contract_status','quantity','publication_contract.is_for_sale','publications.publication_title','contracts.contract_title','contracts.supplier_id','contracts.contract_number','contracts.contract_year','contracts.delivery_date')
        ->get();
        // dd($receipt_publication);
        $per_page = request('per_page') ? request('per_page') : 10;
        $receipts = Receipt::paginate($per_page);
        $total_box = Receipt::all()->sum('box_quantity');
        $total_books_box = Receipt::all()->sum('quantity_per_box');
        $total_books = $total_box * $total_books_box;
        $gross_weight = Receipt::all()->sum('gross_weight');
        return view('receipts.index', compact('receipt_publication','gross_weight', 'receipt_publication', 'receipts', 'total_box', 'total_books_box', 'total_books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'box_quantity' => 'required',
            'quantity_per_box' => 'required',
            'gross_weight' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $request['received_by'] = auth()->user()->id;
            $supplies = Receipt::create($request->all());

            $supplies_id = $supplies->id;
            $supplies_contract_id = $supplies->contract_id;
            $supplies_box_quantity = $supplies->number_of_boxes;
            $supplies_quantity_per_box = $supplies->quantity_per_box;
            $supplies_gross_weight = $supplies->gross_weight;
            // $supplies_is_for_sale = $supplies->is_for_sale;
            $supplies_history = SupplyHistory::create([
                'supplies_id' => $supplies_id,
                'contract_id' => $supplies_contract_id,
                'box_quantity' => $supplies_box_quantity,
                'quantity_per_box' => $supplies_quantity_per_box,
                // 'is_for_sale' => $supplies_is_for_sale,
                'gross_weight' => $supplies_gross_weight,
                'user_id' => auth()->user()->id,
            ]);
            DB::commit();
        } catch (\Exception  $ex) {
            throw $ex;
        }
        Session::flash('success', 'Supplier Supplies Received Successfully');
        return redirect()->route('receipts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $supplies_information = Receipt::findorfail($id);
        return view('receipts.view', compact('supplies_information'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplies_information = Receipt::findorfail($id);
        return view('receipts.edit', compact('supplies_information'));
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
        $supply = Receipt::findorfail($id);
        $this->validate($request, [
            'box_quantity' => 'required',
            'quantity_per_box' => 'required',
            'gross_weight' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $supply->update($request->all());

            $supplies_history = SupplyHistory::create([
                'supplies_id' => $supply->id,
                'contract_id' => $supply->contract_id,
                'box_quantity' => $supply->box_quantity,
                'quantity_per_box' => $supply->quantity_per_box,
                // 'is_for_sale' => $supply->is_for_sale,
                'gross_weight' => $supply->gross_weight,
                'user_id' => auth()->user()->id,
            ]);
            DB::commit();
        } catch (\Exception  $ex) {
            throw $ex;
        }
        Session::flash('success', 'Supplier Supplies Updated Successfully');
        return redirect()->route('receipts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supply = Receipt::findorfail($id);
        $supply->delete();
        Session::flash('error', 'Books Received Successfully');
        return redirect()->route('receipts.index');
    }

    public function contractInformation(Request $request)
    {
        $receipt_publication = DB::table('publication_contract')
        ->leftJoin("publications", 'publications.id', "=", 'publication_contract.publication_id')
        ->leftJoin("contracts", 'contracts.id', "=", 'publication_contract.contract_id')
        ->select('contracts.id AS contract_identifier','contract_status','quantity','publication_contract.is_for_sale','publications.publication_title','contracts.contract_title','contracts.supplier_id','contracts.contract_number','contracts.contract_year','contracts.delivery_date')
        ->get();
        //dd($request->all());    
        $contract_information = Contract::findorfail($request->contract_id);
        $per_page = request('per_page') ? request('per_page') : 10;
        $receipts = Receipt::paginate($per_page);
        $total_box = Receipt::all()->sum('box_quantity', 'quantity_per_box');
        $total_books_box = Receipt::all()->sum('quantity_per_box');
        $total_books = $total_box * $total_books_box;
        $gross_weight = Receipt::all()->sum('gross_weight');

        return view('receipts.index', compact('gross_weight', 'contract_information', 'receipt_publication', 'receipts', 'total_box', 'total_books_box', 'total_books'));
    }
}
