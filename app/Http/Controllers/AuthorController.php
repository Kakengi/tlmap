<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorFormRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = request('per_page') ? request('per_page') : 10;
        $name = request('name');
        if ($name) {
            $search = true;
        } else {
            $search = false;
        }
        $authors = Author::filter($name)->latest()->paginate($per_page);
        return view('authors.index', compact('authors', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authors.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorFormRequest $request)
    {
        try {
            $author = Author::create([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'user_id' => auth()->id(),
            ]);

            if ($author) {
                $request->session()->flash('success', 'Author has been added successfully.');
                switch ($request->btn_action) {
                    case 'save_new':
                        return redirect()->route('authors.create');
                        break;
                    case 'save_edit':
                        return redirect()->route('authors.edit', $author->id);
                        break;
                    case 'save_exit':
                        return redirect()->route('authors.index');
                        break;
                    default:
                        return back();
                        break;
                }
            } else {
                $request->session()->flash('error', 'Unable to save this author, something went wrong.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $request->session()->flash('error', 'Whoops!  This author already exist.');
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
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return $this->create()->with([
            'edit' => true,
            'eAuthor' => $author
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorFormRequest $request, Author $author)
    {
        try {
            $updated = $author->update([
                'name' => $request->name,
                'short_name' => $request->short_name,
            ]);

            if ($updated) {
                $request->session()->flash('success', 'Author has been updated successfully.');
                switch ($request->btn_action) {
                    case 'save_new':
                        return redirect()->route('authors.create');
                        break;
                    case 'save_edit':
                        return redirect()->route('authors.edit', $author->id);
                        break;
                    case 'save_exit':
                        return redirect()->route('authors.index');
                        break;
                    default:
                        return back();
                        break;
                }
            } else {
                $request->session()->flash('error', 'Unable to update this author, something went wrong.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $request->session()->flash('error', 'Whoops!  This author already exist.');
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
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        //
    }
}
