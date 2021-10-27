<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserAccountSettingsController extends Controller {
    

    public function index() {
        $user = Auth::user();
        return view('user_settings', [
            'user' => $user
        ]);
    }


}
