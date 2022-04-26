<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookFormRequest;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\SchoolType;
use App\Models\Subject;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = request()->get('per_page') ? request()->get('per_page') : 10;
        $books = Book::withTrashed()
            ->filter(request()->get('school_type_id'), request()->get('school_class_id'), request()->get('subject_id'), request()->get('book_category_id'))
            ->paginate($per_page);
        $schoolTypes = SchoolType::all();
        $subjects = Subject::orderBy('name', 'ASC')->get();
        $bookCategories = BookCategory::all();
        return view('books.index', compact('books', 'schoolTypes', 'subjects', 'bookCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schoolTypes = SchoolType::all();
        $subjects = Subject::orderBy('name', 'ASC')->get();
        $bookCategories = BookCategory::all();
        return view('books.form', compact('schoolTypes', 'subjects', 'bookCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookFormRequest $request)
    {
        try {
            $book = Book::create([
                'title' => $request->title,
                'description' => $request->description,
                'book_category_id' => $request->book_category_id,
                'school_class_id' => $request->school_class_id,
                'user_id' => auth()->id(),
                'subject_id' => $request->subject_id,
                'num_students_per_book' => $request->num_students_per_book,
            ]);

            if ($book) {
                $request->session()->flash('success', 'A book has been added successfully.');
                switch ($request->btn_action) {
                    case 'save_new':
                        return redirect()->route('books.create');
                        break;
                    case 'save_edit':
                        return redirect()->route('books.edit', $book->id);
                        break;
                    case 'save_exit':
                        return redirect()->route('books.index');
                        break;
                    default:
                        return back();
                        break;
                }
            } else {
                $request->session()->flash('error', 'Unable to save this book, something went wrong.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $request->session()->flash('error', 'Whoops!  This book already exist.');
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
    public function edit(Book $book)
    {
        return $this->create()->with([
            'edit' => true,
            'eBook' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $updated = $book->update([
            'title' => $request->title,
            'description' => $request->description,
            'book_category_id' => $request->book_category_id,
            'school_class_id' => $request->school_class_id,
            'subject_id' => $request->subject_id,
            'num_students_per_book' => $request->num_students_per_book,
        ]);

        if ($updated) {
            $request->session()->flash('success', 'A book has been updated successfully.');
            switch ($request->btn_action) {
                case 'save_new':
                    return redirect()->route('books.create');
                    break;
                case 'save_edit':
                    return redirect()->route('books.edit', $book->id);
                    break;
                case 'save_exit':
                    return redirect()->route('books.index');
                    break;
                default:
                    return back();
                    break;
            }
        } else {
            $request->session()->flash('error', 'Unable to update this book, something went wrong.');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        request()->session()->flash('success', 'Book has been deleted successfully.');
        return back();
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $contract = Book::withTrashed()
            ->whereId($id)
            ->firstOrFail();
        $contract->deleted_at = null;
        if ($contract->save()) {
            request()->session()->flash('success', 'Contract restored successfully');
        }
        return redirect()->route('books.index');
    }
}
