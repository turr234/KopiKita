<?php

namespace App\Http\Controllers;

use App\Models\bank_account;
use App\Models\db_bank_account;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bank_account = bank_account::latest()->paginate(10);
        return view('bank_accounts.index', compact('bank_account'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bank_accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
            'logo' => 'required|file|max:255|mimes:jpeg,jpg,png,gif',
            'intructions' => 'required|string',
            'is_active' => 'required|boolean'
        ]);

        if($request->hasFile('logo')){
            $filepath = $request->file('logo')->store('logo','public');
            $input = $request->all();
            $input['logo'] = $filepath;
        }
        bank_account::create($request->all());
        return redirect()->route('bank_accounts.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(bank_account $bank_account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bank_account = bank_account::findOrFail($id);
        return view('bank_accounts.edit', compact('bank_account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Data
        $request->validate([
            'bank_name'      => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
            'logo'           => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048', // Diubah menjadi nullable
            'intructions'    => 'required|string',
        ]);

        $bank_account = bank_account::findOrFail($id);

        // 2. Ambil data request (kecuali file logo & checkbox)
        $data = $request->except(['logo', 'is_active']);

        // 3. Handle Checkbox is_active (1 jika centang, 0 jika tidak)
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // 4. Handle Upload File Logo jika ada file baru
        if ($request->hasFile('logo')) {
            $filepath = $request->file('logo')->store('logo', 'public');
            $data['logo'] = $filepath;
        }

        // 5. Update Database dengan data yang sudah diolah ($data)
        $bank_account->update($data);

        return redirect()->route('bank_accounts.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bank_account $bank_account)
    {
        $bank_account->delete();
        return redirect()->route('bank_accounts.index')->with('success','Data Berhasil Dihapus');
    }
}
