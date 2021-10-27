
@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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

  <style type="text/css">
    .content-section {
      display: none;
    }
  </style>

  <!-- User's profile page every user can see -->
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-md-4 col-sm-auto">
        <img src="{{ $avatar }}" class="rounded-circle" width="200" height="200">
      </div>

      <div class="col-md-8 col-sm-auto">
        <p class="h3">{{$user->getDisplayName()}}</p>
        <br>
        <span>{{$user->getName()}}</span>
        <br>
        <span>About {{$user->getDisplayName()}}</span>
        <br>
        <span>Pronouns: {{$user->getPronouns()}}</span>
        <br>
        <span>{{$user->getBio()}}</span>
        <br>
        <span>{{$user->getAge()}}</span>
        <br>
        <span>Virgin Status: {{$user->getVirginStatus()}}</span>
      </div>
    </div>
  </div>

  <br>

  <div class="btn-group btn-group-lg">
    <button type="button" data-section="section1" class="btn btn-primary segmentedButton ">Posts</button>
    <button type="button" data-section="section2" class="btn btn-primary segmentedButton">Update Profile</button>
  </div>

  <div class="content-section" id="section1">
    <p>Posts will eventually go here</p>
  </div>

  <div class="content-section" id="section2">
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
          <span>Change Pronouns</span>
          <input type="text" name="pronouns" value="{{$user->getPronouns()}}"></input>
          <span>Change Bio</span>
          <input type="text" name="bio" value="{{$user->getBio()}}"></input>
          <br>
          <span>Change Age</span>
          <input type="text" name="age" value="{{$user->getAge()}}"></input>
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
  </div>

  <script type="text/javascript">
    $(function() {

      $(".btn").on("click", function() {

        //hide all sections
        $(".content-section").hide();

        //show the section depending on which button was clicked
          $("#" + $(this).attr("data-section")).show();
      });

    });
  </script>

@endsection