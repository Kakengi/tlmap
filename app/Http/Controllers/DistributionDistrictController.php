<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Contract;
use App\Models\District;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DistributionDistrict;
use App\Http\Requests\DistributionSchoolFormRequest;
use App\Http\Requests\DistributionDistrictFormRequest;

class DistributionDistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = request('per_page') ? request('per_page') : 10;
        $query = DistributionDistrict::filter(
            request('year'),
            request('district_id'),
            request('region_id')
        )
            ->orderBy('district_id');
        $countQuery = $query->get();
        $lgas = $query->paginate($per_page);
        $total_required_books = 0;
        $total_distributed_books = 0;
        // $total_required_books = DB::table('distribution_districts')->sum(DB::raw('quantity_per_box * number_of_boxes + loose'));
        // $total_distributed_books = DB::table('distribution_districts')->sum(DB::raw('quantity_required'));
        // dd($total_required_books);
        foreach ($countQuery as  $countQ) {
            $total_distributed_books += $countQ->number_of_boxes * $countQ->quantity_per_box + $countQ->loose;
            $total_required_books += $countQ->quantity_required;
            // $total = DB::table('distribution_districts')
            //     ->sum(DB::raw('quantity_per_box * number_of_boxes + loose'));
            // dd($total);
        }

        $contracts = Contract::groupBy("publication_contract.contract_id")
            ->selectRaw("
            SUM((receipts.number_of_boxes * receipts.quantity_per_box) + receipts.loose) AS quantity,
            contract_number,
            contract_title,
            contract_year,
            contracts.id AS id
            ")
            ->leftJoin("publication_contract", "publication_contract.contract_id", "=", "contracts.id")
            ->leftJoin("receipts", "receipts.publication_contract_id", "publication_contract.id")
            ->where('contract_year', request('year'))
            ->where("publication_contract.is_for_sale", false)
            ->where('contracts.contract_status', 'closed')
            ->get();
        // dd($contracts);

        $regions = Region::orderBy('name', 'ASC')->get();
        $selected_region_name = "";
        $selected_district_name = "";
        if (request('district_id')) {
            $district = District::findOrFail(request('district_id'));
            $selected_district_name = $district->name;
        }
        if (request('region_id')) {
            $district = Region::findOrFail(request('region_id'));
            $selected_region_name = $district->name;
        }
        return view('distributions.lga.index', compact('lgas', 'total_required_books', 'total_distributed_books', 'contracts', 'regions', 'selected_district_name', 'selected_region_name'));
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
    public function store(DistributionDistrictFormRequest $request)
    {

        $saved = DistributionDistrict::create([
            'contract_id' => $request->contract_id,
            'publication_id' => $request->publication_id,
            'district_id' => $request->district_id,
            'quantity' => $request->quantity,
            'year_of_study' => $request->year_of_study,
            'user_id' => auth()->id()
        ]);
        if ($saved) {
            $request->session()->flash('success', 'Item save successfully.');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DistributionDistrict  $distributionDistrict
     * @return \Illuminate\Http\Response
     */
    public function show(DistributionDistrict $distributionDistrict)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DistributionDistrict  $distributionDistrict
     * @return \Illuminate\Http\Response
     */
    public function edit(DistributionDistrict $distributionDistrict)
    {
        return $this->index()->with([
            'edit' => true,
            'eDistributionDistrict' => $distributionDistrict
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DistributionDistrict  $distributionDistrict
     * @return \Illuminate\Http\Response
     */
    public function update(DistributionDistrictFormRequest $request, DistributionDistrict $distributionDistrict)
    {

        $saved = $distributionDistrict->update([
            'contract_id' => $request->contract_id,
            'publication_id' => $request->publication_id,
            'district_id' => $request->district_id,
            'quantity' => $request->quantity,
            'year_of_study' => $request->year_of_study,
            'user_id' => auth()->id()
        ]);
        if ($saved) {
            $request->session()->flash('success', 'Item updated successfully.');
        }
        return redirect()->route('distribution_districts.index', ['year' => $request->year_of_study]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DistributionDistrict  $distributionDistrict
     * @return \Illuminate\Http\Response
     */
    public function destroy(DistributionDistrict $distributionDistrict)
    {
        //
    }
}
