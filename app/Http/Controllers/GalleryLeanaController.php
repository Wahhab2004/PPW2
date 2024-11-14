<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryLeana;
use Illuminate\Support\Facades\File;

class GalleryLeanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = GalleryLeana::all();
        $jumlah_data = GalleryLeana::count();
        return view('gallery.index', compact('data', 'jumlah_data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'picture' => 'required|image'
        ]);


         // Menyimpan perubahan di database
         $gallery = new GalleryLeana();
         $gallery->title = $request->input('title');
         $gallery->description = $request->input('description');

        if($request->hasFile('picture')) {

            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();

            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
            $path2 = $request->file('picture')->storeAs($filenameSimpan);

            $gallery->picture = $path2;

        }

        else {
            $filenameSimpan = 'noimage.png';
        }

        $gallery->save();

       

        return redirect('gallery')->with('success', 'Berhasil menambahkah foto baru Leana');
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
    public function destroy(string $id) {
        $gallery = GalleryLeana::find($id);
    
        if (!$gallery) {
            return redirect('gallery')->with('error', 'Data tidak ditemukan');
        }
    
        // Mendapatkan path file foto
        $file = public_path('storage/' . $gallery->photo);
    
        try {
            // Hapus file foto jika ada
            if (File::exists($file)) {
                File::delete($file);
            }
    
            // Hapus gall$gallery dari database
            $gallery->delete();
    
            return redirect('gallery')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect('gallery')->with('error', 'Gagal hapus data');
        }
    }
    

    public function edit(string $id) {
        $gallery = GalleryLeana::find($id);
    
        if (!$gallery) {
            return redirect('gallery')->with('error', 'Data tidak ditemukan');
        }
    
        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, string $id) {
        $gallery = GalleryLeana::find($id);
    
        if (!$gallery) {
            return redirect('users')->with('error', 'Data tidak ditemukan');
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        // Update data pengguna
        $gallery->name = $request->name;
        $gallery->email = $request->email;
    
        // Jika ada file foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            $oldFile = public_path('storage/' . $gallery->picture);
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
    
            // Simpan foto baru
            $newFile = $request->file('picture')->store('gall$gallerys', 'public');
            $gallery->photo = $newFile;
        }
    
        $gallery->save();
    
        return redirect('users')->with('success', 'Data berhasil diupdate');
    }
}
