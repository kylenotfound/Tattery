
@extends('layouts.app')

@section('scripts')
  <script src="{{ asset('js/tattoo/dash.js') }}"></script>
@endsection

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

  <style type="text/css">
    .content-section {
      display: none;
    }
  </style>

  <!-- User's profile page every user can see -->
  <div class="container">
    <div class="row d-flex align-items-center">
      <div class="col col-sm-6 d-flex justify-content-center">
        <img src="{{ $avatar }}" class="rounded-circle mb-4 mb-sm-0" width="200" height="200">
      </div>

      <div class="col col-sm-6  text-left">
        <p class="h5 my-0">{{$user->getDisplayName()}}</p>
        <div class="div">
            @if(auth()->user() != $user)
            <follow
              user-id="{{$user->getId()}}"
              state="{{auth()->user()->isFollowing($user)}}"
              followers-count="{{count($user->followers)}}"
              following-count="{{count($user->following())}}"
            />
            @endif
        </div>
        <br>
        <span><b>{{$user->getName()}}</b>
          <span style="font-size: 16px;" class="ml-1"><i>Age: {{$user->getAge()}} </i>| <i>Pronouns: {{$user->getPronouns()}} </i>| <i>Virgin Status: {{$user->getVirginStatus()}}</i></span>
        </span>
        <br>
        <span>{{$user->getBio()}}</span>
        <br>
        <div>
          <followcounter
            followers-count="{{count($user->followers)}}"
            following-count="{{count($user->following())}}"
          />
        </div>
        <span>Total Likes: {{ $user->getAllLikes() }}</span>
      </div>
    </div>
  </div>

  <br>

  <div class="container">
    <div class="btn-group btn-group-sm d-flex flex-row justify-content-evenly pb-3">
      <button id="posts" type="button" data-section="section1" class="btn btn-dark segmentedButton">Posts</button>
      @if(Auth::user()->id == $user->id)
        <button type="button" data-section="section2" class="btn btn-dark segmentedButton">Edit Profile</button>
      @endif
    </div>

    <div class="content-section" id="section1">
      <!-- This user's posts -->
      <div>
        <div>
            @if(count($tattoos) == 0)
              <span>No posts to display.</span>
            @endif
            @foreach($tattoos as $tattoo)
              <div class="card border-dark mb-2 align-items-center" style="width: 275px">
              <p><i class='fas fa-map-marker-alt'></i>{{ $tattoo->getLocation() }}</p>
              <img src="{{Helpers::getUsersTattoos($tattoo, $user)}}" width="250px" height="250px" />
                <div>
                    <like
                        tattoo-id= "{{ $tattoo->getId() }}"
                        likes= "{{ $user->isLiking($tattoo) }}"
                        count= "{{ $tattoo->getNumOflikes() }}"
                    />
                </div>
                <p>{{ $tattoo->getDescription() }}</p>
                <form action="{{route('tattoo.delete', ['id' => $tattoo->getId()])}}" method="POST">
                  @csrf
                  <label>Delete Post</label>
                  <input type="submit" onClick="return confirm('Are you sure you want to delete your tattoo?')"></input>
                </form>
              </div>
            @endforeach
            {{$tattoos->links()}} <!--Links to another subpage if there are more than the paginated tattoos -->
        </div>
      </div>
    </div>

    <div class="content-section" id="section2">
      <!--If the user logged in is the same user that owns the profile, display profile customization features -->

      @if(Auth::user()->id == $user->id)
        <div>
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
            <br>

            <label>Change Pronouns</label>
            <input type="text" name="pronouns" value="{{$user->getPronouns()}}"></input>
            <br>

            <label>Change Bio</label>
            <input type="text" name="bio" value="{{$user->getBio()}}"></input>
            <br>

            <label>Change Age</label>
            <input type="text" name="age" value="{{$user->getAge()}}"></input>
            <br>

            <label>Change Virgin Status</label>
            <select name="virgin_status">
              <option value="Virgin">Virgin</option>
              <option value="Non virgin">Not a Virgin</option>
              <option vlaue="N/A">N/A</option>
            </select>
            <br>

            <input type="submit" class="btn-dark"></input>
          </form>
        </div>
      @endif
    </div>
  </div>
@endsection
