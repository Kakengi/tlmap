<?php

namespace App\Http\Controllers;

use App\Models\DistributionDistrict;
use App\Models\District;
use App\Models\Publication;
use App\Models\SchoolClass;
use App\Models\SchoolRequirement;
use App\Services\HelperService;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //
    protected $helper;
    public function __construct(HelperService $helper)
    {
        $this->helper = $helper;
    }
    public function getDistrictsByRegion(Request $request)
    {
        $districts = District::selectRaw('id,name')
            ->where('region_id', $request->region_id)
            ->get();

        return response()->json(
            view('includes.district_options', compact('districts', 'request'))->render()
        );
    }
    public function getSchoolClasses()
    {
        $school_type_id = request()->get('school_type_id');
        $school_class_ids = request()->get('school_class_id');
        $classess = SchoolClass::where('school_type_id', $school_type_id)->get();
        if (is_array($school_class_ids) && count($school_class_ids) > 0) {
        } else {
            $school_class_ids = [request()->get('school_class_id')];
        }
        return response()->json([
            'success' => $classess ? true : false,
            'data' =>  view(
                'school_requirements.includes.school_classes_options',
                compact('classess', 'school_class_ids')
            )->render(),
            'class_ids' => request()->get('school_class_id')
        ]);
    }

    public function getAggregateNumBookRequired(Request $request)
    {
        if ($request->publication_id) {
            $publication = Publication::findOrFail($request->publication_id);
            $book = $publication->book;
            $query = SchoolRequirement::selectRaw("SUM(required_books) AS total_books")
                ->groupBy(['subject_id', 'year_of_study', 'school_class_id'])
                ->whereRaw(
                    "year_of_study = ? AND school_class_id = ? AND subject_id = ?",
                    [$publication->publication_year, $book->school_class_id, $book->subject_id]
                );
            if ($request->district_id) {
                $query = $query->where('district_id', $request->district_id);
            }
            if ($request->school_id) {
                $query = $query->where('school_id', $request->school_id);
            }
            $query = $query->first();
            if ($query) {
                return $query->total_books;
            }
            return response()->json(false);
        }
    }

    public function listPublicationReceived(Request $request)
    {

        $publications = $this->helper->receivedBooks($request)->get();
        // dd($publications);
        return response()->json(
            view('distributions.includes.publication_list_options', compact('publications', 'request'))
                ->render()
        );
    }

    public function remainReceivedPublication(Request $request)
    {
        $publication = $this->helper->receivedBooks($request)->first();
        if ($publication) {
            return $publication->quantity;
        }
        return 0;
    }

    public function storeBulkLGAsData(Request $request)
    {

        $data = $this->helper->getBulkLGAsData($request);
        if (count($data) > 0) {
            DistributionDistrict::truncate();
            $inserted = DistributionDistrict::insert($data);
        } else {
            $inserted = false;
        }
        return response()->json([
            'success' => $inserted ? true : false,
            'message' => $inserted ? "Data was generated successfully," . count($data) . " row(s) created" : "Whooops!  No Data found"
        ]);
    }
}
