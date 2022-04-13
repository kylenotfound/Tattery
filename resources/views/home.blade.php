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
      <div class="d-flex justify-content-center card-deck">
        @if(count($tattoos) == 0)
            <span>No posts to display.</span>
        @endif
        @foreach($tattoos as $tattoo)
          @include('tattoo.structure', ['tattoo' => $tattoo])
        @endforeach
      </div>
    </div>

    {{$tattoos->links()}}
@endsection


