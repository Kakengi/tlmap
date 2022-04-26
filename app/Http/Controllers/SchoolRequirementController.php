<?php

namespace App\Http\Controllers;

use App\Models\SchoolLevel;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Models\SchoolRequirement;
use App\Models\SchoolType;
use App\Models\Subject;

use function GuzzleHttp\Promise\all;

class SchoolRequirementController extends Controller
{
    protected $helper;
    public function __construct(HelperService $helper)
    {
        $this->helper = $helper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(request()->get('school_class_id'));
        $year = request()->get('year') ? request()->get('year') : date('Y');
        $school_name = request()->get('school_name');
        $school_type_id = request()->get('school_type_id');
        $school_class_id = request()->get('school_class_id');
        $subject_id = request()->get('subject_id');
        $per_page = request()->get('per_page') ? request()->get('per_page') : 10; 
        $schoolRequirements = SchoolRequirement::search($school_name , $school_type_id , $school_class_id , $subject_id)
                                                ->filterByYear($year)
                                                ->orderBy('school_id' , 'ASC')
                                                ->orderBy('year_of_study' , 'DESC')
                                                ->paginate($per_page);
        $schoolTypes = 
        $schoolObject = $this->helper->getTotalNumStudentBook($year , $school_name , $school_type_id , $school_class_id , $subject_id);
        $schoolTypes = SchoolType::all();
        $subjects = Subject::all();
        // dd($schoolRequirements);
        return view('school_requirements.requirements_index' , compact('schoolRequirements' , 'year' , 'schoolObject','schoolTypes','subjects'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolRequirement  $schoolRequirement
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolRequirement $schoolRequirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolRequirement  $schoolRequirement
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolRequirement $schoolRequirement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolRequirement  $schoolRequirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolRequirement $schoolRequirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolRequirement  $schoolRequirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolRequirement $schoolRequirement)
    {
        //
    }
}
