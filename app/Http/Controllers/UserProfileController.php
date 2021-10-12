<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller {
    
    public function index($id) {
        $user = User::where('display_name', '=', $id)->first();
        return view('dash', [
            'display_name' => $user->getDisplayName(),
            'name' => $user->getName(),
            'bio' => $user->getBio()
        ]);
    }

    public function updateName($newName) {

    }

    public function updateDisplayName($newDisplayName) {

    }

    public function updateBio($newBio) {

    }
}
