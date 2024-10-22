<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_penerbit = Publisher::all();

        return view('publishers.index', compact('data_penerbit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publishers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        try {
            // Simpan penerbit baru
            Publisher::create($validatedData);

            // Flash message success jika berhasil
            return redirect()->route('publishers.index')->with('success', 'Publisher created successfully!');
        } catch (\Exception $e) {
            // Flash message error jika gagal
            return redirect()->back()->with('error', 'Failed to create publisher: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data anggota berdasarkan id
        $penerbit = Publisher::findOrFail($id);

        // Tampilkan view edit dengan data anggota
        return view('publishers.edit', compact('penerbit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        try {
            // Ambil penerbit berdasarkan ID
            $penerbit = Publisher::findOrFail($id);

            // Update data penerbit dengan data yang baru
            $penerbit->update($validatedData);

            // Flash message sukses jika berhasil
            return redirect()->route('publishers.index')->with('success', 'Publisher updated successfully!');
        } catch (\Exception $e) {
            // Flash message error jika gagal
            return redirect()->back()->with('error', 'Failed to update publisher: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Ambil penerbit berdasarkan ID
            $penerbit = Publisher::findOrFail($id);

            // Delete data penerbit
            $penerbit->delete();

            // Flash message sukses jika berhasil
            return redirect()->route('publishers.index')->with('success', 'Publisher deleted successfully!');
        } catch (\Exception $e) {
            // Flash message error jika gagal
            return redirect()->back()->with('error', 'Failed to delete publisher: ' . $e->getMessage());
        }
    }
}
