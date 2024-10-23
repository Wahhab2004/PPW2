@extends('layout.master')

@section('title', 'Member List')

@section('content')
    <h2 class="text-center mb-4">Member List</h2>
    <form action="{{ route('members.search') }}" method="GET">
        @csrf
        <input type="text" name="search" class="form-control mb-2" placeholder="Search Member">
    </form>
    <a href="{{ route('members.create') }}" class="btn btn-primary float-end mb-2">Add Member</a>
    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Birth Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_anggota as $index => $anggota)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $anggota->id }}</td>
                    <td>{{ $anggota->full_name }}</td>
                    <td>{{ $anggota->phone_number }}</td>
                    <td>{{ $anggota->email }}</td>
                    <td>{{ $anggota->address }}</td>
                    <td>{{ $anggota->birth_date ? $anggota->birth_date->translatedFormat('d F Y') : 'unavailable' }}</td>
                    <td>
                        <form action="{{ route('members.edit', $anggota->id) }}">
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </form>
                        <form action="{{ route('members.destroy', $anggota->id) }}" method="POST">
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
    <!-- Menampilkan jumlah anggota -->
    <div class="row mt-3">
        <div class="col-md-6">
            <p><strong>Total Members:</strong> {{ $jumlah_anggota }}</p>
        </div>
    </div>
@endsection
