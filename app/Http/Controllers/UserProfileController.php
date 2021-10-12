<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller {
    
    public function index($id) {
        $user = User::where('display_name', '=', $id)->first();
        if ($user == null) {
            return view('welcome')->withErrors(['user not found' => 'user does not exist']);
        }
        return view('dash', [
            'user' => $user
        ]);
    }

    public function updateName($newName) {

    }

    public function updateDisplayName($newDisplayName) {

    }

    public function updateBio($newBio) {

    }
}
