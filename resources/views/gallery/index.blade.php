{{-- @extends('layout.master')
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
   
   
   
@endsection --}}



@extends('layout.master')

@section('title', 'Book Gallery')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="row" id="gallery">
                        {{-- @if (count($galleries) > 0)
                            @foreach ($galleries as $gallery)
                                <div class="col-sm-2">
                                    <div>
                                        <a class="example-image-link" href="{{ 'storage/images/books/' . $gallery->picture }}"
                                            data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                            <img class="example-image img-fluid mb-2"
                                                src="{{ asset('storage/images/books/' . $gallery->picture) }}"
                                                alt="image-gallery" width="200" />
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3>Tidak ada data.</h3>
                        @endif
                        <div class="d-flex">
                            {{ $galleries->links() }}
                        </div> --}}

                        <!-- Konten akan diisi oleh script -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $.get('http://localhost:8000/api/gallery', function(response) {
            console.log('Response dari API:', response);
            if (response['data']) {
                var html = '';
                response['data'].forEach(function(gallery) {
                    html += `
                        <div class="col-sm-2">
                            <div>
                                <a class="example-image-link" href="storage/posts_image/${gallery.picture}" data-lightbox="roadtrip" data-title="${gallery.description}">
                                    <img class="example-image img-fluid mb-2" src="storage/posts_image/${gallery.picture}" alt="${gallery.title}" width="200" />
                                </a>
                            </div>
                        </div>`;
                });
                console.log('HTML yang akan dimasukkan:', html);
                $('#gallery').html(html);
            } else {
                $('#gallery').html('<h3>Tidak ada data.</h3>');
            }
            }).fail(function() {
                console.error('Gagal memuat data dari API.');
                $('#gallery').html('<h3>Gagal memuat data dari API.</h3>');
            });
        });
    </script>
@endsection