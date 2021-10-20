<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class TattooController extends Controller {
    
    public function index() {
        return view('tattoo.upload');
    }

    public function store(Request $request) {
        $user = Auth::user();

        $request->validate([
            'tattoo' => 'required',
            'description' => 'nullable'
        ]);

    }

}
