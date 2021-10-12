@extends('layouts.app')

@section('content')

<p>{{$user->getName()}}</p>

  @if(Auth::user()->id == $user->id)
    <button>This will eventually allow for a photo upload/change</button>
  @endif

@endsection