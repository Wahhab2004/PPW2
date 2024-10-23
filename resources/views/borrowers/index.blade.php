@extends('layout.master')

@section('title', 'Borrower List')

@section('content')
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
                        <td class="text-white"><span class="bg-danger rounded-pill px-2 pb-1">Not returned yet</span></td>
                    @endif
                    <td>{{ $peminjam->due_date->translatedFormat('d F Y H:i') }}</td>
                    @if ($peminjam->fine || $peminjam->fine == 0)
                        <td>{{ 'Rp. ' . number_format($peminjam->fine, 2, ',', '.') }}</td>
                    @else
                        <td class="text-white"><span class="bg-danger rounded-pill px-2 pb-1">Not returned yet</span></td>
                    @endif

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

    <!-- Tampilkan pagination links -->
    <div class="d-flex justify-content-center">
        {{ $data_peminjam->links() }}
    </div>

    <!-- Menampilkan jumlah peminjam dan total denda peminjam -->
    <div class="row mt-3">
        <div class="col-md-6">
            <p><strong>Total Books:</strong> {{ $jumlah_peminjam }}</p>
        </div>
        <div class="col-md-6 text-end">
            <p><strong>Total Fine:</strong> {{ 'Rp. ' . number_format($total_denda_peminjam, 2, ',', '.') }}</p>
        </div>
    </div>
@endsection
