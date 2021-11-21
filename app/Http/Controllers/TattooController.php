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
            'location' => 'nullable|max:50',
            'description' => 'nullable|max:150'
        ]);

        if($request->hasFile('tattoo')) {
            $tattooImage = $request->file('tattoo');
            $tattooNameToStore = self::uploadAndSaveTattooPost($user, $tattooImage);
        }

        $tattoo = new Tattoo;
        $tattoo->user_id = $user->id;
        $tattoo->tattoo_image_name = $tattooNameToStore;
        $tattoo->location = $request->input('location');
        $tattoo->description = $request->input('description');
        $tattoo->save();

        return redirect()->route('home')->with(['success' => 'tattoo post created!']);

    }

    public function delete($id) {
        $user = Auth::user();
        $tattoo = Tattoo::find($id);

        if ($tattoo == null) {
            return back()->withErrors(['error' => 'could not delete tattoo']);
        }

        //Check the public tattoos storage dir exists
        if (File::exists('./storage/tattoos')) {
            //get all the uploads in the storage dir
            $uploads = File::files('./storage/tattoos');
            //foreach upload in the storage dir
            foreach ($uploads as $upload) {
                //foreach tattoo row associated with the user at hand, 
                if (basename($upload) == $tattoo->getTattooImageName()) {
                    File::delete($upload);
                }
            }
        }

        if (File::exists('./storage/users/' . $user->getStorageDir() . '/uploads/')) {
            $uploads = File::files('./storage/users/' . $user->getStorageDir() . '/uploads/');
            //loop through each upload and remove it from the uploads dir
            foreach($uploads as $upload) {
                if (basename($upload) == $tattoo->getTattooImageName()) {
                    File::delete($upload);
                }
            }
        }

        $tattoo->delete();

        return back()->with(['success' => 'tattoo succesfully deleted!']);

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
