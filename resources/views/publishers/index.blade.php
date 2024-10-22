@extends('layout.master')

@section('title', 'Publisher List')

@section('content')
    <h2 class="text-center mb-4">Publisher List</h2>
    <a href="{{ route('publishers.create') }}" class="btn btn-primary float-end mb-2">Add Publisher</a>
    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_penerbit as $index => $penerbit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penerbit->id }}</td>
                    <td>{{ $penerbit->name }}</td>
                    <td>{{ $penerbit->address }}</td>
                    <td>
                        <form action="{{ route('publishers.edit', $penerbit->id) }}">
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </form>
                        <form action="{{ route('publishers.destroy', $penerbit->id) }}" method="POST">
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
@endsection
