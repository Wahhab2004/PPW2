@extends('layout.master')

@section('title', 'Edit Member')

@section('content')
    <h2 class="text-center mb-4">Edit Member</h2>

    <form action="{{ route('members.update', $anggota->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Untuk metode update -->

        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name"
                value="{{ old('full_name', $anggota->full_name) }}" required>
            @error('full_name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number"
                value="{{ old('phone_number', $anggota->phone_number) }}" required>
            @error('phone_number')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', $anggota->email) }}" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address"
                value="{{ old('address', $anggota->address) }}" required>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Birt Date</label>
            <input type="text" class="form-control" id="birth_date" name="birth_date"
                value="{{ old('birth_date', $anggota->birth_date) }}" placeholder="YYYY-MM-DD" required>
            @error('birth_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Member</button>
    </form>
@endsection
