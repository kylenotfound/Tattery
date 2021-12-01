<div class="container">
  <div class="card border-dark mb-2" style="width: 300px">
    <div class="card-header ">
      <img src="{{Helpers::getUserAvatar($tattoo->user)}}" width="30px" height="30px" class="rounded-circle"></img>
      <a href="{{route('dash', ['id' => $tattoo->user->getDisplayName()])}}">{{$tattoo->user->getDisplayName()}}</a>
      @if($tattoo->getLocation() != null)
        <p style="margin-bottom: 0"><i class='fas fa-map-marker-alt'></i> {{ $tattoo->getLocation() }}</p>
      @endif
    </div>
    <div class="card-body align-items-center" style="width: 275px">
        <img src="{{Helpers::getPublicImageLocationOfTattoo($tattoo)}}" width="250px" height="250px" />
        <p>{{ $tattoo->getDescription() }}</p>
    </div>
  </div>
</div>