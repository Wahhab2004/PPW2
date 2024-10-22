@extends('layout.master')

@section('title', 'Create Publisher')

@section('content')
    <h2 class="text-center mb-4">Create New Publisher</h2>

    <form action="{{ route('publishers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" rows="3"
                required></textarea>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
