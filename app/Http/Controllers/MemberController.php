<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_anggota = Member::all();

        return view('members.index', compact('data_anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input termasuk birth_date
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:members,phone_number',
            'email' => 'required|string|email|max:255|unique:members,email',
            'address' => 'required|string',
            'birth_date' => 'required|date',
        ]);

        try {
            // Simpan buku baru
            Member::create($validatedData);

            // Flash message success jika berhasil
            return redirect()->route('members.index')->with('success', 'Member created successfully!');
        } catch (\Exception $e) {
            // Flash message error jika gagal
            return redirect()->back()->with('error', 'Failed to create member: ' . $e->getMessage());
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
        $anggota = Member::findOrFail($id);

        // Tampilkan view edit dengan data anggota
        return view('members.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:members,phone_number,' . $id, // dilakukan dengan pengecualian untuk record yang sedang diedit (dengan parameter $id), agar validasi unik tidak memeriksa diri sendiri.
            'email' => 'required|string|email|max:255|unique:members,email,' . $id,
            'address' => 'required|string',
            'birth_date' => 'required|date',
        ]);

        try {
            // Ambil anggota berdasarkan ID
            $anggota = Member::findOrFail($id);

            // Update data anggota dengan data yang baru
            $anggota->update($validatedData);

            // Flash message sukses jika berhasil
            return redirect()->route('members.index')->with('success', 'Member updated successfully!');
        } catch (\Exception $e) {
            // Flash message error jika gagal
            return redirect()->back()->with('error', 'Failed to update member: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Ambil anggota berdasarkan ID
            $anggota = Member::findOrFail($id);

            // Delete data anggota
            $anggota->delete();

            // Flash message sukses jika berhasil
            return redirect()->route('members.index')->with('success', 'Member deleted successfully!');
        } catch (\Exception $e) {
            // Flash message error jika gagal
            return redirect()->back()->with('error', 'Failed to delete member: ' . $e->getMessage());
        }
    }
}
