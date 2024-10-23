@extends('layout.master')

@section('title', 'Search Borrower')

@section('content')
    @if (count($data_peminjam))
        <div class="alert alert-success mb-4">
            Ditemunkan <strong>{{ count($data_peminjam) }}</strong> data dengan kata: <strong>{{ $search }}</strong>
        </div>

        <h2 class="text-center mb-4">Borrower List</h2>
        <form action="{{ route('borrowers.search') }}" method="GET">
            @csrf
            <input type="text" name="search" class="form-control mb-2" placeholder="Search Borrower">
        </form>
        <a href="{{ route('borrowers.create') }}" class="btn btn-primary float-end mb-2">Add Borrower</a>
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Member ID</th>
                    <th>Book ID</th>
                    <th>Loan Date</th>
                    <th>Return Date</th>
                    <th>Due Date</th>
                    <th>Fine</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_peminjam as $index => $peminjam)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $peminjam->id }}</td>
                        <td>{{ $peminjam->member->full_name }}</td> <!-- Menampilkan nama lengkap member -->
                        <td>{{ $peminjam->book->title }}</td> <!-- Menampilkan judul buku -->
                        <td>{{ $peminjam->loan_date->translatedFormat('d F Y H:i') }}</td>
                        @if ($peminjam->return_date)
                            <td>{{ $peminjam->return_date->translatedFormat('d F Y H:i') }}</td>
                        @else
                            <td class="text-danger">Not returned yet</td>
                        @endif
                        <td>{{ $peminjam->due_date->translatedFormat('d F Y H:i') }}</td>
                        <td>{{ 'Rp. ' . number_format($peminjam->fine, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('borrowers.edit', $peminjam->id) }}">
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            <form action="{{ route('borrowers.destroy', $peminjam->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin mau dihapus?')" type="submit"
                                    class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Menampilkan jumlah peminjam dan total denda peminjam -->
        <div class="row mt-3">
            <div class="col-md-6">
                <p><strong>Total Books:</strong> {{ $jumlah_peminjam }}</p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Total Fine:</strong> {{ 'Rp. ' . number_format($total_denda_peminjam, 2, ',', '.') }}</p>
            </div>
        </div>
    @else
        <div class="alert alert-danger mb-4">
            <h4>Data {{ $search }} tidak ditemukan</h4>
            <a href="/borrowers" class="btn btn-warning">Kembali</a>
        </div>
    @endif
@endsection
