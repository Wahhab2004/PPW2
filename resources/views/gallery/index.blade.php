@extends('layout.master')
@section('content')


    <a href="{{ route('gallery.create') }}" class="btn btn-primary" style="margin-left: 12rem" >Add Photos</a>

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dasboard Leana</div>
                <div class="card-body">
                    <div class="row">
                        @if($jumlah_data > 0)
                        @foreach($data as $gallery)
                        <div class="col-sm-2">
                            <div>
                                <a href="{{ asset('storage/posts_image/'.$gallery->picture) }}" class="example-image-link" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                    <img src="{{ asset('storage/posts_image/'.$gallery->picture) }}" alt="image-1" class="example-image img-fluid mb-2 rounded  border-danger-subtle border border-2 object-fit-cover" style="height:100px;" width="200">
                                </a>
                                <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning">Edit</a>

                                <form action="{{ route('gallery.destroy', $gallery->id ) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                    
                                    <br>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <h3>Tidak ada data</h3>
                        @endif
                        {{-- <div class="d-flex">
                            {{ $data->links() }}
                        </div> --}}
                       
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection