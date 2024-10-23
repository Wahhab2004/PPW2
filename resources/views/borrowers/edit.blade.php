@extends('layout.master')

@section('title', 'Edit Borrower')

@section('content')
    <h2 class="text-center mb-4">Edit Borrower</h2>

    <form action="{{ route('borrowers.update', $peminjam->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="member_id" class="form-label">Member</label>
            <select class="form-control" name="member_id" id="member_id" required>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" {{ $member->id == $peminjam->member_id ? 'selected' : '' }}>
                        ({{ $member->id }})
                        {{ $member->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="book_id" class="form-label">Book</label>
            <select class="form-control" name="book_id" id="book_id" required>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ $book->id == $peminjam->book_id ? 'selected' : '' }}>
                        ({{ $book->id }})
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="loan_date" class="form-label">Loan Date</label>
            <input type="datetime-local" class="form-control" name="loan_date" id="loan_date"
                value="{{ $peminjam->loan_date->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mb-3">
            <label for="return_date" class="form-label">Return Date</label>
            <input type="datetime-local" class="form-control" name="return_date" id="return_date"
                value="{{ $peminjam->return_date ? $peminjam->return_date->format('Y-m-d\TH:i') : '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Borrower</button>
    </form>
@endsection
