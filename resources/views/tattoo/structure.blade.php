
<div class="card-deck" style="padding-bottom: 20px">
  <div class="container">
    <div class="card border-dark mb-2" style="width: 300px; height: 450px">
      <div class="card-header">
        <img src="{{Helpers::getUserAvatar($tattoo->user)}}" width="35px" height="35px" class="rounded-circle mb-2"></img>
        <a href="{{route('dash', ['id' => $tattoo->user->getDisplayName()])}}">{{$tattoo->user->getDisplayName()}}</a>
        <br />
        <i class='fas fa-map-marker-alt'></i> {{ $tattoo->getLocation() != null ? $tattoo->getLocation() : 'No Location Provided' }}
      </div>
      <div class="card-body align-items-center" style="width: 275px">
        <img class="cover" src="{{Helpers::getPublicImageLocationOfTattoo($tattoo)}}" width="250px" height="250px" />
        <div class="mt-2">
          <like
            tattoo-id= "{{ $tattoo->getId() }}"
            likes= "{{ auth()->user()->isLiking($tattoo) }}"
            count= "{{ $tattoo->getNumOflikes() }}"
          />
        </div>
        <span>{{ $tattoo->getDescription() }}</span>
      </div>
    </div>
  </div>
</div>
