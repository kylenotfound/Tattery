@extends('layouts.app')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('success'))
      <div class="alert alert-success">
          {{ session()->get('success') }}
      </div>
    @endif

  <p>{{$user->getDisplayName()}}</p>

  <!--If the user logged in is the same user that owns the profile, display profile customization features -->
  @if(Auth::user()->id == $user->id)
    <div>
      <!-- Temporary test button to ensure our bootstrap is working fine.-->
      <button type="button" class="btn btn-primary">Primary</button>

      <form action="{{route('dash.update_display_name', ['id' => $user->getDisplayName()])}}" method="POST">
        @csrf
        <input type="text" name="new_display_name"></input>
        <input type="submit"></input>
      </form>
    </div>
  @endif

@endsection