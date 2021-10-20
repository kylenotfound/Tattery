@extends('layouts.app')
  
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
          <label>Description: </label>
          <textarea class="form-control" maxLength="500" id="description" name="description" oninput="lengthCheck(this)"></textarea>
          <p id="chars"></p>
        </div>
        <div class="col-md-12">
          <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </div>
      </div>     
    </form>
  </div>  

  <script>
    $(document).ready(function (e) {
      $('#image').change(function(){     
        let reader = new FileReader();
        reader.onload = (e) => { 
          $('#preview-image-before-upload').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
      });
    });

    function lengthCheck(element) {
      var max = 150;
      var textArea = element.value.length;
      var charactersLeft = max - textArea;
      var count = document.getElementById('chars');
      count.innerHTML = "Characters left: " + charactersLeft;
    }
    lengthCheck(document.getElementById('newTwet'));

  </script>

@endsection