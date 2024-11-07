<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => "posts",
            'menu' => "Gallery",
            'galleries' => Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );
        return view('gallery.index')->with($data);
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
            'title' => 'required|string|max:250',
            'description' => 'required',
            'picture' => 'nullable|image|max:1999'
        ]);

        if($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();

            $basename = uniqid() . time();
            $smallFilename = "small {$basename}.{$extension}";
            $mediumFilename = "medium {$basename}.{$extension}";
            $largeFilename = "large {$basename}.{$extension}";
            $filenameSimpan = "$basename}.{$extension}";

            $path = $request->file('picture')->storeAs('post_image', $filenameSimpan);
        }
        else {
            $filenameSimpan = 'noimage.png';
        }

        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return redirect('gallery') -> with('success', 'Berhasil menambahkan data baru');

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
    public function edit(string $id) {
        $gallery = Post::find($id);
    
        if (!$gallery) {
            return redirect('gallery')->with('error', 'Data tidak ditemukan');
        }
    
        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, string $id) {
        $gallery = Post::find($id);
    
        if (!$gallery) {
            return redirect('gallery')->with('error', 'Data tidak ditemukan');
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        // Update data pengguna
        $gallery->title = $request->title;
        $gallery->description = $request->description;
    
        // Jika ada file foto baru
        if ($request->hasFile('picture')) {
            // Hapus foto lama jika ada
            $oldFile = public_path('storage/post_image/' . $gallery->picture);
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
    
            // Mengambil informasi file asli
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
    
            // Membuat nama file sesuai format yang diinginkan
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
    
            // Simpan file ke direktori storage/app/public/post_image
            $path = $request->file('picture')->storeAs('post_image', $filenameSimpan, 'public');
            $path2 = $request->file('picture')->storeAs($filenameSimpan);
    
            // Update path gambar di database
            $gallery->picture = $path2;
        }
    
        $gallery->save();
    
        return redirect('gallery')->with('success', 'Data berhasil diupdate');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $gallery = Post::find($id);
    
        if (!$gallery) {
            return redirect('gallery')->with('error', 'Data tidak ditemukan');
        }
    
        // Mendapatkan path file foto
        $file = public_path('storage/post_image/' . $gallery->picture);
    
        try {
            // Hapus file foto jika ada
            if (File::exists($file)) {
                File::delete($file);
            }
    
            // Hapus user dari database
            $gallery->delete();
    
            return redirect('gallery')->with('success', 'Berhasil hapus  oi');
        } catch (\Throwable $th) {
            return redirect('gallery')->with('error', 'Gagal hapus data');
        }
    }
    
}
