@extends('layout.master')
@section('content')

    <table class="table table-responsive-lg">

        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Photo</td>
            <td>Action</td>
        </tr>
    
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
    
            <td>
                @if($user->photo)
                <img src="{{ asset('storage/'.$user->photo) }}" alt="" width="100px">
                @else
                <img src="{{ asset('noimage.jpg') }}" alt="" width="100px">
                @endif
            </td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>

                <form action="{{ route('users.destroy', $user->id ) }}" method="POST">
                    @method('DELETE')
                    @csrf
    
                    <br>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    @endsection
    