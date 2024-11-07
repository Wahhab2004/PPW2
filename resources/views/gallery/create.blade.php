<form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">

    @csrf
    <div class="mb-3 row">
        <label for="title" class="cold-md-4 col-form-label text-md-end text-start">Title</label>
        <div class="col-md-6">
            <input type="text" name="title" id="title" class="form-control">
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        </div>
    </div>
  
    <div class="mb-3 row">
        <label for="description" class="cold-md-4 col-form-label text-md-end text-start">Description</label>
        <div class="col-md-6">
            <textarea rows="5" name="description" id="description" class="form-control"></textarea>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        </div>
    </div>

    <div class="mb-3 row">
        <label for="input-file" class="cold-md-4 col-form-label text-md-end text-start">File input</label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="file" name="picture" id="input-file" class="custom-file-input">
                <label for="input-file" class="custom-file-label">Choose File</label>
            </div>
            

        </div>
    </div>
  

    <button type="submit" class="btn btn-primary">Submit</button>

</form>