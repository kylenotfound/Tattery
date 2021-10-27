@extends('layouts.app')

@section('content')

  <h1>{{$user->getDisplayName() }} Settings</h1>
  <form action="{{route('user.delete', ['id' => $user->getDisplayName()])}}" method="POST">
    @csrf
    <button type="submit">test</button>
  </form>

@endsection