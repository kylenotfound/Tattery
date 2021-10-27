<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tattoo;
use Auth;

class HomeController extends Controller {
    
    public function index() {

        //TODO follower scoped tattoos returned for home page
        $user = Auth::user();
        $tattoos = Tattoo::orderBy('created_at', 'desc')->paginate(10);

        return view('home', [
            'user' => $user,
            'tattoos' => $tattoos,
        ]);
    }

}
