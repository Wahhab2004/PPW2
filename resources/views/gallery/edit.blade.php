@extends('layout.master')

@section('content')
<div class="container">
    <h2>Edit Photo</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">description</label>
            <input type="description" class="form-control" id="description" name="description" value="{{ old('description', $gallery->description) }}" required>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="picture" class="form-label">Picture</label>
            @if($gallery->picture)
                <div>
                    <img src="{{ asset('storage/post_image' . $gallery->picture) }}" alt="gallery picture" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                </div>
            @endif
            <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
            @error('picture')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
