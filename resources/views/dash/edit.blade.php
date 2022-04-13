@extends('layouts.app')

@section('content')

  <!-- Display Errors to the user if there are any in a list format-->
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="container">
    <div class=" d-flex row justify-content-center mb-2">
      <div class="col-md-8">
        <form enctype="multipart/form-data" action="{{route('dash.update_profile', ['id' => $user->getDisplayName()])}}" method="POST">
          @csrf
          <label class="form-label">Change Photo</label>
          <input class="form-control mb-2" type="file" name="avatar" />
    
          <label class="form-label">Change Name</label>
          <input class="form-control mb-2" type="text" name="name" placeholder="{{ $user->getName() }}"/>
    
          <label class="form-label">Change Username</label>
          <input class="form-control mb-2" type="text" name="new_display_name" placeholder="{{ $user->getDisplayName() }}"/>
    
          <label class="form-label">Change Pronouns</label>
          <input class="form-control mb-2" type="text" name="pronouns" placeholder="{{ $user->getPronouns() }}"/>
    
          <label class="form-label">Change Bio</label>
          <textarea class="form-control mb-2" type="text" name="bio">{{ $user->getBio() }}</textarea>
    
          <div class="row">
            <div class="col-md-6">
              <label class="form-label">Change Age</label>
              <input class="form-control mb-2" type="number" name="age" value="{{$user->getAge()}}" placeholder="{{ $user->getAge() }}"/>
            </div>
            <div class="col-md-6">
              <label class="form-label">Change Virgin Status</label>
              <select class="form-control mb-2" name="virgin_status">
                <option value="Virgin">Virgin</option>
                <option value="Non virgin">Not a Virgin</option>
                <option vlaue="N/A">N/A</option>
              </select>
            </div>
          </div>
    
          <input type="submit" class="btn btn-secondary btn-dark" />
        </form>
      </div>
    </div>
  </div>
@endsection