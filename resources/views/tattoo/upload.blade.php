@extends('layouts.app')

@section('scripts')
  <script src="{{ asset('js/tattoo/upload.js') }}"></script>
@endsection
  
@section('content')
  <div class="container mt-4">
    <form method="POST" enctype="multipart/form-data" id="upload-image" action="{{ route('tattoo.upload-store') }}">
      @csrf    
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Select a tattoo</label>
            <br>
            <input type="file" name="tattoo" placeholder="Choose image" id="image">
              @error('tattoo')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
        </div>
        <div class="col-md-12 mb-2">
          <img id="preview-image-before-upload">
        </div>
        <div class="col-md-12 mb-2">
          <label>Location: </label>
          <input type="text" class="form-control" name="location" placeholder="Enter a location" id="location" maxLength="50" oninput="lengthCheckLocation(this)">
          <p id="loc"></p>
        </div>
        <div class="col-md-12 mb-2">
          <label>Description: </label>
          <textarea class="form-control" maxLength="150" id="description" name="description" oninput="lengthCheckDescription(this)"></textarea>
          <p id="desc"></p>
        </div>
        <div class="col-md-12">
          <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </div>
      </div>     
    </form>
  </div>  

@endsection