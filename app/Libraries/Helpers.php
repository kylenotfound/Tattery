<?php

namespace App\Libraries;

use App\Models\User;

class Helpers {

  public static function getUserAvatar(User $user) {
    return asset('/storage/users/' . $user->getStorageDir() . '/avatars/' . $user->getAvatar());
  }

}