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
      <span>Update Username</span>
      <form enctype="multipart/form-data" action="{{route('dash.update_profile', ['id' => $user->getDisplayName()])}}" method="POST">
        @csrf
        <label>Change Photo</label>
        <input type="file" name="avatar"></input>
        <br>
        <label>Change Name</label>
        <input type="text" name="name" value="{{$user->getName()}}"></input>
        <br>
        <label>Change Username</label>
        <input type="text" name="new_display_name" value="{{$user->getDisplayName()}}"></input>
<<<<<<< HEAD
        <br>
        <label>Change Bio</label>
=======
        <span>Change Pronouns</span>
        <input type="text" name="pronouns" value="{{$user->getPronouns()}}"></input>
        <span>Change Bio</span>
>>>>>>> a7b825c6deea6bbd9908842c9cab6b2dfcc891e6
        <input type="text" name="bio" value="{{$user->getBio()}}"></input>
        <br>
        <label>Change Virgin Status</label>
        <select name="virgin_status">
          <option value="Virgin">Virgin</option>
          <option value="Non virgin">Not a Virgin</option>
          <option vlaue="N/A">N/A</option>
        </select>
        <br>
        <input type="submit"></input>
      </form>
    </div>
  @endif

  <!-- User's profile page every user can see -->
  
    <div>
      <img src="{{ $avatar }}" width="130" height="130">
      <br>
      <span>{{$user->getName()}}</span>
      <br>
      <span>About {{$user->getDisplayName()}}</span>
      <br>
      <span>Pronouns: {{$user->getPronouns()}}</span>
      <br>
      <span>{{$user->getBio()}}</span>
      <br>
      <span>Virgin Status: {{$user->getVirginStatus()}}</span>
    </div>

@endsection