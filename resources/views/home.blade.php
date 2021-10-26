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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(count($tattoos) == 0)
                    <span>No posts to display.</span>
                @endif
                @foreach($tattoos as $tattoo)
                    <div class="card mb-2">
                        <img src="{{Helpers::getUserAvatar($tattoo->user)}}" width="30px" height="30px"></img>
                        <a href="{{route('dash', ['id' => $tattoo->user->getDisplayName()])}}">{{$tattoo->user->getDisplayName()}}</a>
                        <img src="{{Helpers::getPublicImageLocationOfTattoo($tattoo)}}" width="250px" height="250px" />
                        <p>{{ $tattoo->getDescription() }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{$tattoos->links()}}
@endsection
