@extends('layout.master')

@section('title', 'Send Email')

@section('content')
    <div class="row justify-content-center">
        <h3 class="text-center">Kirim Email</h3>
        <div class="col-md-12 p-12">
            {{-- Flash message untuk sukses dan error --}}
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form kirim email --}}
            <form action="{{ route('post.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" placeholder="Nama" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-3">
                    <label for="email">Email Tujuan</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        id="email" placeholder="Email Tujuan" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-3">
                    <label for="subject">Subjek</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject"
                        id="subject" placeholder="Subjek" value="{{ old('subject') }}">
                    @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-3">
                    <label for="body">Body Deskripsi</label>
                    <textarea name="body" class="form-control @error('body') is-invalid @enderror" id="body" cols="30"
                        rows="10">{{ old('body') }}</textarea>
                    @error('body')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Kirim Email</button>
                </div>
            </form>
        </div>
    </div>
@endsection
