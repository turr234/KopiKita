<?php

namespace App\Http\Controllers;

use App\Models\addresse;
use App\Models\db_addresse;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class AddresseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresse = addresse::latest()->paginate(10);
        return view('addresses.index', compact('addresse'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::all();
        return view('addresses.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'full_address' => 'required|string',
            'is_primary' => 'required|boolean'
        ]);

        addresse::create($request->all());
        return redirect()->route('addresses.index')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(addresse $addresse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $addresse = addresse::findOrFail($id);
        return view('addresses.edit', compact('addresse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'full_address' => 'required|string',
            'is_primary' => 'required|boolean'
        ]);
        $addresse = addresse::findOrFail($id);
        $addresse->update($request->all());

        return redirect()->route('addresses.index')->with('success', 'Data Berhsil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(addresse $addresse)
    {
        $addresse->delete();
        return redirect()->route('addresses.index')->with('success','Data Berhasil Dihapus');
    }
}
