
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

  <!-- User's profile page every user can see -->
  <div class="container">
    <div class="row d-flex align-items-center">
      <div class="col col-sm-6 d-flex justify-content-center">
        <img src="{{ $avatar }}" class="rounded-circle mb-4 mb-sm-0" width="200" height="200">
      </div>

      <div class="col col-sm-6 text-left">
        <h3 class="my-0">{{$user->getDisplayName()}}</h3>
        <br />
        <div>
          <span><b>{{ $user->getName() }}</b></span> <br />
          <span>Age: {{ $user->getAge() }}</span> |
          <span>Pronouns: {{ $user->getPronouns() }} </span>| 
          <span>Virgin Status: {{ $user->getVirginStatus() }}</span>
        </div>
        <br>
        <span>{{$user->getBio()}}</span>
        <br>
        <div class="row">
          <div class="col-md-8">
            <div>
              <followcounter
                followers-count="{{count($user->followers)}}"
                following-count="{{count($user->following)}}"
              />
            </div>
            <div>
              <likecounter
                like-count="{{$user->getAllLikes()}}"
              />
            </div>
            <div class="d-flex justify-content-end">
              @if(auth()->id() != $user->getId())
                <follow
                  user-id="{{$user->getId()}}"
                  state="{{auth()->user()->isFollowing($user)}}"
                  followers-count="{{count($user->followers)}}"
                  following-count="{{count($user->following)}}"
                />
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr />
    <div class="d-flex justify-content-center card-deck pb-4">
      @forelse($tattoos as $tattoo)
        <div class="card-deck p-4">
          <div class="card border-dark post-body mb-2 mr-2">
            <div class="card-header post-head">
              <img src="{{ Helpers::getUserAvatar($tattoo->user)}}" width="35px" height="35px" class="rounded-circle mb-2"></img>
              <a href="{{route('dash', ['id' => $tattoo->user->getDisplayName()])}}">{{$tattoo->user->getDisplayName()}}</a>
              <br />
              <i class='fas fa-map-marker-alt'></i> {{ $tattoo->getLocation() != null ? $tattoo->getLocation() : 'No Location Provided' }}
            </div>
            <div class="card-body align-items-center">
                <img class="cover" src="{{ Helpers::getUsersTattoos($tattoo, $user) }}" width="250px" height="250px"/>
                <div>
                  <like
                    tattoo-id="{{ $tattoo->getId() }}"
                    likes="{{ auth()->user()->isLiking($tattoo) }}"
                    count="{{ $tattoo->getNumOflikes() }}"
                  />
                </div>
                <span>{{ $tattoo->getDescription() }}</span>
            </div>
            <div class="card-footer">
              @if(auth()->user()->getDisplayName() == $user->getDisplayName())
                <form action="{{route('tattoo.delete', ['id' => $tattoo->getId()])}}" method="POST">
                  @csrf
                  <input type="submit" value="Delete" onClick="return confirm('Are you sure you want to delete your tattoo?')"></input>
                </form>
              @endif
            </div>
          </div>
        </div>
      @empty
        <span>No posts to display.</span>
      @endforelse
      {{$tattoos->links()}} <!--Links to another subpage if there are more than the paginated tattoos -->
    </div>
  </div>
@endsection

@section('styles')
  <style type="text/css">
    .content-section {
      display: none;
    }
    .post-head {
      height: 50px;
    }
    .post-body {
      width: 300px;
      height: 450px;;
    }
  </style>
@endsection
