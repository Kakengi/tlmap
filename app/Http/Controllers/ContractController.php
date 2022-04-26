<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractFormRequest;
use App\Models\Contract;
use App\Models\Publication;
use App\Models\SchoolType;
use App\Models\Subject;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolTypes = SchoolType::all();
        $subjects = Subject::all();
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        $per_page = request('per_page') ? request('per_page') : 10;
        $publications = Publication::orderBy('publication_year', 'DESC')->get();
        $contracts = Contract::withTrashed()->filter(request('contract_year'))->latest()->paginate($per_page);
        return view('contracts.index', compact('contracts', 'publications', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractFormRequest $request)
    {
        $contract = Contract::create([
            'supplier_id' => $request->supplier_id,
            'contract_title' => $request->contract_title,
            'contract_number' => $request->contract_number,
            'delivery_date' => $request->delivery_date,
            'contract_year' => $request->contract_year,
            'year_of_study' => $request->year_of_study,
            'user_id' => auth()->id()
        ]);
        if ($contract) {
            $request->session()->flash('success', 'Contract created successfully.');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        return (new PublicationContractController)->index($contract);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        return $this->index()->with([
            'edit' => true,
            'eContract' => $contract
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractFormRequest $request, Contract $contract)
    {
        $updated = $contract->update([
            'supplier_id' => $request->supplier_id,
            'contract_title' => $request->contract_title,
            'contract_number' => $request->contract_number,
            'delivery_date' => $request->delivery_date,
            'year_of_study' => $request->year_of_study,
            'contract_year' => $request->contract_year,
        ]);
        if ($updated) {
            $request->session()->flash('success', 'Contract updated successfully.');
        }
        return redirect()->route('contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        $trashed = $contract->delete();
        if ($trashed) {
            request()->session()->flash('success', 'Contract deleted successfully');
        }
        return redirect()->route('contracts.index');
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $contract = Contract::withTrashed()
            ->whereId($id)
            ->firstOrFail();
        $contract->deleted_at = null;
        if ($contract->save()) {
            request()->session()->flash('success', 'Contract restored successfully');
        }
        return redirect()->route('contracts.index');
    }
}
