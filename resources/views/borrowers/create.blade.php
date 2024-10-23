@extends('layout.master')

@section('title', 'Create Borrower')

@section('content')
    <h2 class="text-center mb-4">Create New Borrower</h2>

    <form action="{{ route('borrowers.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="member_id">Nama Anggota</label>
            <select name="member_id" class="form-control" required>
                <option value="">Pilih Anggota</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">({{ $member->id }}) {{ $member->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="book_id">Judul Buku</label>
            <select name="book_id" class="form-control" required>
                <option value="">Pilih Buku</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}">({{ $book->id }}) {{ $book->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="loan_date">Tanggal Pinjam</label>
            <input type="datetime-local" name="loan_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
