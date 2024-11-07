<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User;
use FFI;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        if(!Auth::check()) {
            return redirect() -> route('login')->withErrors(
                ['email' => 'Please login to access the users.',]
            )->onlyInput('email');
        }
        $users = User::get();
        return view('users.users') -> with('users', $users);
    }

    public function destroy(string $id) {
        $user = User::find($id);
    
        if (!$user) {
            return redirect('users')->with('error', 'Data tidak ditemukan');
        }
    
        // Mendapatkan path file foto
        $file = public_path('storage/' . $user->photo);
    
        try {
            // Hapus file foto jika ada
            if (File::exists($file)) {
                File::delete($file);
            }
    
            // Hapus user dari database
            $user->delete();
    
            return redirect('users')->with('success', 'Berhasil hapus  oi');
        } catch (\Throwable $th) {
            return redirect('users')->with('error', 'Gagal hapus data');
        }
    }
    

    public function edit(string $id) {
        $user = User::find($id);
    
        if (!$user) {
            return redirect('users')->with('error', 'Data tidak ditemukan');
        }
    
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id) {
        $user = User::find($id);
    
        if (!$user) {
            return redirect('users')->with('error', 'Data tidak ditemukan');
        }
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        // Update data pengguna
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Jika ada file foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            $oldFile = public_path('storage/' . $user->photo);
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
    
            // Simpan foto baru
            $newFile = $request->file('photo')->store('users', 'public');
            $user->photo = $newFile;
        }
    
        $user->save();
    
        return redirect('users')->with('success', 'Data berhasil diupdate');
    }
    
    

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

}
