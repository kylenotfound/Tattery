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

}