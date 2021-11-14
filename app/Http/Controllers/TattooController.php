<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tattoo;
use App\Models\User;
use Auth;
use File;

class TattooController extends Controller {
    
    public function index() {
        return view('tattoo.upload');
    }

    public function store(Request $request) {
        $user = Auth::user();

        $request->validate([
            'tattoo' => 'required|mimes:jpg,jpeg,png|max:10000',
            'description' => 'nullable|max:150'
        ]);

        if($request->hasFile('tattoo')) {
            $tattooImage = $request->file('tattoo');
            $tattooNameToStore = self::uploadAndSaveTattooPost($user, $tattooImage);
        }

        $tattoo = new Tattoo;
        $tattoo->user_id = $user->id;
        $tattoo->tattoo_image_name = $tattooNameToStore;
        $tattoo->description = $request->input('description');
        $tattoo->save();

        return redirect()->route('home')->with(['success' => 'tattoo post created!']);

    }

    private static function uploadAndSaveTattooPost($user, $tattoo) {
        //path were storing the image
        $userPath = '/public/users/' . $user->getStorageDir() . '/uploads/';
        $tattosPath = '/public/tattoos';
        //get attributes of image
        $newTattoo = $tattoo->getClientOriginalName();
        $fileName = pathinfo($newTattoo, PATHINFO_FILENAME);
        $extension = $tattoo->getClientOriginalExtension();
        //create new unique file name
        $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
        //store image to users personal tattoos dir and the public explore dir
        $tattoo->storeAs($userPath, $fileNameToStore);
        $tattoo->storeAs($tattosPath, $fileNameToStore);
        return $fileNameToStore;
    }

}
