<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Member;
use App\Models\Borrower;
use Carbon\Carbon;

class BorrowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batas = 20;
        // Mengambil data peminjam dengan relasi member dan book, urutkan berdasarkan loan_date terbaru
        $data_peminjam = Borrower::with(['member', 'book'])->orderBy('loan_date', 'desc')->paginate($batas);
        $jumlah_peminjam = Borrower::count(); // Menghitung jumlah peminjam di database
        $total_denda_peminjam = Borrower::sum('fine'); // Menjumlahkan semua denda peminjam di database
        $no = $batas * ($data_peminjam->currentPage() - 1);

        return view('borrowers.index', compact('data_peminjam', 'jumlah_peminjam', 'total_denda_peminjam', 'no'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search'); // Kata kunci pencarian

        // Melakukan pencarian di tabel borrowers berdasarkan full_name (member) dan title (book)
        $data_peminjam = Borrower::whereHas('member', function ($query) use ($search) {
            $query->where('full_name', 'like', '%' . $search . '%');
        })->orWhereHas('book', function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->get();

        $jumlah_peminjam = Borrower::count(); // Menghitung total peminjam di database
        $total_denda_peminjam = Borrower::sum('fine'); // Menjumlahkan denda peminjam

        return view('borrowers.search', compact('data_peminjam', 'jumlah_peminjam', 'total_denda_peminjam', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika ada relasi dengan Member dan Book, ambil data nya
        $members = Member::all();
        $books = Book::all();
        return view('borrowers.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
        ]);

        try {
            // Menghitung due_date (14 hari setelah loan_date)
            $due_date = Carbon::parse($request->loan_date)->addDays(14);

            // Membuat data peminjam baru
            Borrower::create([
                'member_id' => $request->member_id,
                'book_id' => $request->book_id,
                'loan_date' => $request->loan_date,
                'due_date' => $due_date,
                'return_date' => null,
                'fine' => null,
            ]);

            return redirect()->route('borrowers.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
        // Ambil data buku berdasarkan id
        $peminjam = Borrower::findOrFail($id);

        // Ambil semua data buku dan anggota untuk dropdown
        $members = Member::all();
        $books = Book::all();

        // Tampilkan view edit dengan data buku dan publisher
        return view('borrowers.edit', compact('peminjam', 'members', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date', // return_date bisa dikosongkan
        ]);

        try {
            // Ambil peminjam berdasarkan ID
            $peminjam = Borrower::findOrFail($id);

            // Hitung due_date 14 hari setelah loan_date
            $dueDate = Carbon::parse($request->input('loan_date'))->addDays(14);

            // Cek apakah return_date diisi
            if ($request->input('return_date')) {
                $returnDate = Carbon::parse($request->input('return_date'));

                // Hitung selisih antara return_date dan due_date
                // floor() untuk membulatkan hasil ke bawah
                $daysLate = floor($returnDate->diffInDays($dueDate, false));

                // Jika terlambat, hitung denda. Jika tidak terlambat, denda adalah 0
                $fine = ($daysLate < 0) ? $daysLate * -1000 : 0;
            } else {
                // Jika return_date kosong, denda adalah 0
                $fine = null;
            }

            // Update data peminjam dengan data yang baru
            $peminjam->update([
                'member_id' => $validatedData['member_id'],
                'book_id' => $validatedData['book_id'],
                'loan_date' => $validatedData['loan_date'],
                'return_date' => $validatedData['return_date'],
                'due_date' => $dueDate,
                'fine' => $fine,
            ]);

            return redirect()->route('borrowers.index')->with('success', 'Borrower updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update borrower: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Ambil peminjam berdasarkan ID
            $peminjam = Borrower::findOrFail($id);

            // Delete data peminjam
            $peminjam->delete();

            // Flash message sukses jika berhasil
            return redirect()->route('borrowers.index')->with('success', 'Borrower deleted successfully!');
        } catch (\Exception $e) {
            // Flash message error jika gagal
            return redirect()->back()->with('error', 'Failed to delete borrower: ' . $e->getMessage());
        }
    }
}
