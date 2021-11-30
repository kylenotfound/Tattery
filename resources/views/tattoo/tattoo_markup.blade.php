<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <img class="rounded-circle" src="{{Helpers::getUserAvatar($user)}}" width="75px" height="75px"></img>
          <a href="{{route('dash', ['id' => $user->getDisplayName()])}}" class="h5">{{$user->getDisplayName()}}</a>
          <div class="h6 p-2">
            <span>Location: {{$tattoo->getLocation()}}</span>
          </div>
        </div>
        <div class="card-img-body">
          <img class="img-thumbnail" src="{{Helpers::getPublicImageLocationOfTattoo($tattoo)}}" alt="{{$tattoo->getTattooImageName()}}">
        </div>
        <div class="card-footer">
            <like
                tattoo-id= "{{ $tattoo->getId() }}"
                original-like-state= "{{ $user->isLiking($tattoo) }}"
                original-like-count= "{{ Helpers::likes($user, $tattoo) }}"
            >
            </like>
            <span>{{$tattoo->getDescription()}}</span>
        </div>
      </div>
    </div>
  </div>
</div>
