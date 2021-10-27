@extends('layouts.app')

@section('content')

  <h1>{{$user->getDisplayName() }} Settings</h1>
  <form action="{{route('user.delete', ['id' => $user->getDisplayName()])}}" method="POST">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-lg text-dark" 
      onclick="return confirm('Are you sure you want to delete your account? All of your uploads will be deleted along with it.')">
      Delete Account
    </button>
  </form>

@endsection