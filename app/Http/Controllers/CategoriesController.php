<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\db_categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories= categories::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:150',
            'description' => 'required|string',
            'image' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'is_active' => 'required|boolean'
        ]);

        if($request->hasFile('image')) {
            $filepPath = $request->file('image')->store('image','public');
            $input = $request->all();
            $input['image'] = $filepPath;
        }
        categories::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categories $id)
    {
        $categories = categories::findOrFail($id);
        return view('categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, categories $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:150',
            'description' => 'required|string',
            'image' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'is_active' => 'required|boolean'
        ]);
        $categories = categories::findOrFail($id);
        $categories->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categories $categories)
    {
        //
    }
}
