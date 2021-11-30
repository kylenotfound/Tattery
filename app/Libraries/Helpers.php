<?php

namespace App\Libraries;

use App\Models\User;
use App\Models\Tattoo;

class Helpers {

  public static function getUserAvatar(User $user) {
    return asset('/storage/users/' . $user->getStorageDir() . '/avatars/' . $user->getAvatar());
  }

  public static function getPublicImageLocationOfTattoo(Tattoo $tattoo) {
    return asset('/storage/tattoos/' . $tattoo->getTattooImageName());
  }

  public static function getUsersTattoos(Tattoo $tattoo, User $user) {
    return asset('/storage/users/' . $user->getStorageDir() . '/uploads/' . $tattoo->getTattooImageName());
  }

  public static function likes(User $user, Tattoo $tattoo) : int {
    //return the count of users that like the tattoo
    return $tattoo->likers(User::class)->count();
  }

}
