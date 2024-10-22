@extends('layout.master')

@section('title', 'Edit Publisher')

@section('content')
    <h2 class="text-center mb-4">Edit Publisher</h2>

    <form action="{{ route('publishers.update', $penerbit->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Untuk metode update -->

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $penerbit->name) }}"
                required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea type="text" class="form-control" id="address" name="address" rows="3" required>{{ old('address', $penerbit->address) }}</textarea>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Publisher</button>
    </form>
@endsection
