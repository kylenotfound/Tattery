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

    <!-- Show success messages to user -->
    @if(session()->has('success'))
      <div class="alert alert-success">
          {{ session()->get('success') }}
      </div>
    @endif

  <p>{{$user->getDisplayName()}}</p>

  <!--If the user logged in is the same user that owns the profile, display profile customization features -->
  @if(Auth::user()->id == $user->id)
    
    <div>
      <!-- Form for updating all fields of user profile: name, username and bio (avatar soon) -->
      <span>Update Username</span>
      <form enctype="multipart/form-data" action="{{route('dash.update_profile', ['id' => $user->getDisplayName()])}}" method="POST">
        @csrf
        <label>Change Name</label>
        <input type="text" name="name" value="{{$user->getName()}}"></input>
        <label>Change Username</label>
        <input type="text" name="new_display_name" value="{{$user->getDisplayName()}}"></input>
        <label>Change Bio</label>
        <input type="text" name="bio" value="{{$user->getBio()}}"></input>
        <label>Change Virgin Status</label>
        <select name="virgin_status">
          <option>Select</option>
          <option value="Virgin">Virgin</option>
          <option value="Non virgin">Not a Virgin</option>
          <option vlaue="N/A">N/A</option>
        </select>
        <label>Change Photo</label>
        <input type="file" name="avatar"></input>
        <input type="submit"></input>
      </form>
    </div>
  @endif

  <!-- User's profile page every user can see -->
  
    <div>
      <img src="{{asset('/storage/users/' . $user->getStorageDir() . '/avatars/' . $user->getAvatar())}}" width="30" height="30">
      <br>
      <span>{{$user->getName()}}</span>
      <br>
      <span>About {{$user->getDisplayName()}}</span>
      <br>
      <span>{{$user->getBio()}}</span>
      <br>
      <span>Virgin Status: {{$user->getVirginStatus()}}</span>
    </div>

@endsection