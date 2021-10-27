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
      <span>{{$user->getAge()}}</span>
      <br>
      <span>Virgin Status: {{$user->getVirginStatus()}}</span>
    </div>
  <!-- This user's posts -->
  <div>
    <div>
        @if(count($tattoos) == 0)
          <span>No posts to display.</span>
        @endif
        @foreach($tattoos as $tattoo)
          <div class="card mb-2">
            <img src="{{Helpers::getUsersTattoos($tattoo, $user)}}" width="250px" height="250px" />
            <p>{{ $tattoo->getDescription() }}</p>
          </div>
          <form action="{{route('tattoo.delete', ['id' => $tattoo->getId()])}}" method="POST">
            @csrf
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                . . .
              </button>
              <div class="dropdown-menu">
                <button type="submit" class="dropdown-item" onClick="return confirm('Are you sure you want to delete your tattoo?')">Delete Post</button>                
              </div>
            </div>
          </form>
        @endforeach
        {{$tattoos->links()}} <!--Links to another subpage if there are more than the paginated tattoos -->
    </div>
  </div>

@endsection