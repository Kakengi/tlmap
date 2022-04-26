<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;
use App\Models\SchoolType;
use App\Models\Publication;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Http\Requests\PublicationFormRequest;

class PublicationController extends Controller
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
        $per_page = request()->get('per_page') ? request()->get('per_page') : 10;
        $publications = Publication::withTrashed()
            ->filter(request('school_type_id'), request()->get('school_class_id'), request()->get('subject_id'), request()->get('book_category_id'), request('publication_year'), request('is_large_print'))
            ->paginate($per_page);
        $schoolTypes = SchoolType::all();
        $subjects = Subject::orderBy('name', 'ASC')->get();
        $bookCategories = BookCategory::all();
        return view('publications.index', compact('publications', 'schoolTypes', 'subjects', 'bookCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $school_type_id = request('school_type_id');
        $school_class_id = request('school_class_id');
        if ($school_type_id || $school_class_id) {
            $books = Book::filter($school_type_id, $school_class_id, false, false)
                ->orderBy('title', 'ASC')->get();
        } else {
            $books = [];
        }
        $schoolTypes = SchoolType::all();
        $authors = Author::orderBy('name', 'ASC')->get();
        return view('publications.form', compact('books', 'authors', 'schoolTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublicationFormRequest $request)
    {
        try {
            $file = '';
            if ($request->file('filename')) {
                $this->validate($request, [
                    'filename' => 'mimes:pdf'
                ]);

                $file = $this->helper->uploadFile($request, '', '');
                if ($request->file('filename') && !$file) {
                    $request->session()->flash('error', 'Unable to upload file already exist, please rename it or contact Admin.');
                    return back();
                }
            }
            $publication = Publication::create([
                'book_id' => $request->book_id,
                'publication_title' => $request->publication_title,
                'author_id' => $request->author_id,
                'number_of_pages' => $request->number_of_pages,
                'publication_year' => $request->publication_year,
                'user_id' => auth()->id(),
                'filename' => $file,
                'is_large_print' => $request->is_large_print == "on" || $request->is_large_print ? 1 : 0
            ]);

            if ($publication) {
                $request->session()->flash('success', 'A publication has been added successfully.');
                switch ($request->btn_action) {
                    case 'save_new':
                        return redirect()->route('publications.create', $_GET);
                        break;
                    case 'save_edit':
                        return redirect()->route('publications.edit', [$publication->id, 'school_type_id' => request('school_type_id'), 'school_class_id' => request('school_class_id')]);
                        break;
                    case 'save_exit':
                        return redirect()->route('publications.index');
                        break;
                    default:
                        return back();
                        break;
                }
            } else {
                $request->session()->flash('error', 'Unable to save this publication, something went wrong.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $request->session()->flash('error', 'Whoops!  This publication already exist.');
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
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        return $this->create()->with([
            'edit' => true,
            'ePublication' => $publication
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(PublicationFormRequest $request, Publication $publication)
    {
        try {
            $file = '';
            if ($request->file('filename')) {
                $this->validate($request, [
                    'filename' => 'mimes:pdf'
                ]);

                $file = $this->helper->uploadFile($request, $publication->filename, 'update');
                if ($request->file('filename') && !$file) {
                    $request->session()->flash('error', 'Unable to upload file already exist, please rename it or contact Admin.');
                    return back();
                }
            }

            $updated = $publication->update([
                'book_id' => $request->book_id,
                'publication_title' => $request->publication_title,
                'author_id' => $request->author_id,
                'number_of_pages' => $request->number_of_pages,
                'publication_year' => $request->publication_year,
                'is_large_print' => $request->is_large_print == "on" || $request->is_large_print ? 1 : 0,
                'filename' => $file
            ]);

            if ($updated) {
                $request->session()->flash('success', 'A publication has been updated successfully.');
                switch ($request->btn_action) {
                    case 'save_new':
                        return redirect()->route('publications.create', $_GET);
                        break;
                    case 'save_edit':
                        return redirect()->route('publications.edit', [$publication->id, 'school_type_id' => request('school_type_id'), 'school_class_id' => request('school_class_id')]);
                        break;
                    case 'save_exit':
                        return redirect()->route('publications.index');
                        break;
                    default:
                        return back();
                        break;
                }
            } else {
                $request->session()->flash('error', 'Unable to update this publication, something went wrong.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $request->session()->flash('error', 'Whoops!  This publication already exist.');
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
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        //
    }
}
