<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wilayah = Wilayah::all();
        return view('wilayah.index', compact('wilayah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'jenis' => 'required|string|max:50',
            'wilayah_induk' => 'nullable|string|max:255',
        ]);

        Wilayah::create([
            'nama_wilayah' => $request->nama_wilayah,
            'jenis' => $request->jenis,
            'wilayah_induk' => $request->wilayah_induk,
        ]);

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wilayah $wilayah)
    {
        return response()->json($wilayah);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wilayah $wilayah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wilayah $wilayah)
    {
        $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'jenis' => 'required|string|max:50',
            'wilayah_induk' => 'nullable|string|max:255',
        ]);

        $wilayah->update([
            'nama_wilayah' => $request->nama_wilayah,
            'jenis' => $request->jenis,
            'wilayah_induk' => $request->wilayah_induk,
        ]);

        return redirect()->route('wilayah.index')->with('success', 'Data Wilayah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wilayah $wilayah)
    {
        $wilayah->delete();
        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil dihapus!');
    }
}
