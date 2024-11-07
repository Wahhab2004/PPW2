@extends('layout.master')

@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    Selamat Datang, {{ Auth::user()->name }}
                    {{-- rahasia123 --}}
                    <a class="btn btn-primary d-block mt-5" href="{{ route('publishers.index') }}">Publisher List</a>
                    <a class="btn btn-primary d-block mt-3" href="{{ route('books.index') }}">Book List</a>
                    <a class="btn btn-primary d-block mt-3" href="{{ route('members.index') }}">Member List</a>
                    <a class="btn btn-primary d-block mt-3" href="{{ route('borrowers.index') }}">Borrower List</a>
                    <a class="btn btn-primary d-block mt-3" href="{{ route('gallery.index') }}">Gallery</a>
                </div>
            </div>
        </div>
    </div>
@endsection 
 