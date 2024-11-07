@extends('layout.master')
@section('content')


   
    <div class="row justify-content-center mt-5">
        <a href="{{ route('gallery.create') }}" class="btn btn-primary m-4 col-5">Add Picture</a>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dasboard</div>
                <div class="card-body">
                    <div class="row">
                        @if(count($galleries) > 0)
                        @foreach($galleries as $gallery)
                        <div class="col-sm-2">
                            <div>
                                <a class="example-image-link" href="{{ asset('storage/posts_image/'.$gallery->picture) }}" data-lighbox="roadtrip" data-title="{{ $gallery->description }}"> 
                                    <img class="example-image img-fluid mb-2 object-fit-cover border rounded" src="{{ asset('storage/post_image/'.$gallery->picture) }}" alt="image-1" height="100px"></a>
                            </div>
                            <form action="{{ route('gallery.edit', $gallery->id) }}" class="col col-12">
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            
                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" class="col col-12">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin mau dihapus?')" type="submit"
                                    class="btn btn-danger">Delete</button>
                            </form>
                           
                        </div>
                        @endforeach
                        @else

                        <h3>Tidak ada data.</h3>
                        @endif
                        <div class="d-flex">
                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   
   
@endsection