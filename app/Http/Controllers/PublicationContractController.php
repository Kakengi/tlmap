<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicationContractFormRequest;
use App\Models\Contract;
use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($contract)
    {
        $publications = Publication::all();
        $contracts = Contract::orderBy('contract_year', 'DESC')->get();
        return view('contracts.printing_contract', compact('contract', 'publications', 'contracts'));
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
    public function store(PublicationContractFormRequest $request, $contract_id)
    {
        try {
            $contract = Contract::findOrFail($contract_id);
            $saved = $contract->publication()->save(Publication::findOrFail($request->publication_id), [
                'quantity' => $request->quantity,
                'is_for_sale' => $request->is_for_sale ? true : false,
            ]);
            if ($saved) {
                $request->session()->flash('success', 'Item saved successfully.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $request->session()->flash('error', 'Whoops!  duplicate entry.');
            } else {
                $request->session()->flash('error', 'Whoops!  Something went wrong try again or contact Administrator.');
            }
            return back()->withInput($request->all());
        }

        return back();
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
    public function edit($contract_id, $id)
    {
        $contract = Contract::findOrFail($contract_id);
        $eContractDetails = $contract->publication->where('pivot.id', $id)->first();
        if ($eContractDetails) {
            return $this->index($contract)->with([
                'edit' => true,
                'eContractDetails' => $eContractDetails->pivot
            ]);
        }
        request()->session()->flash('error', 'Whoops! Something is wrong, Unable to edit contact Administrator.');
        return redirect()->route('contracts.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PublicationContractFormRequest $request, $contract_id, $id)
    {
        try {
            $contract = Contract::findOrFail($contract_id);
            $contractDetails = $contract->publication->where('pivot.id', $id)->first()->pivot;
            $contractDetails->publication_id = $request->publication_id;
            $contractDetails->quantity = $request->quantity;
            $contractDetails->is_for_sale = $request->is_for_sale ? true : false;
            if ($contractDetails->save()) {
                $request->session()->flash('success', 'Item updated successfully.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $request->session()->flash('error', 'Whoops!  duplicate entry.');
            } else {
                $request->session()->flash('error', 'Whoops!  Something went wrong try again or contact Administrator.');
            }
            return back()->withInput($request->all());
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
