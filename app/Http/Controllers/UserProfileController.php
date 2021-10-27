<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Helpers;
use App\Models\Tattoo;
use App\Models\User;
use File;
use Auth;

class UserProfileController extends Controller {
    
    public function index($id) {
        $user = User::where('display_name', '=', $id)->first();
        if ($user == null) {
            return view('home')->withErrors(['user not found' => 'user does not exist']);
        }
        return view('dash', [
            'user' => $user,
            'avatar' => Helpers::getUserAvatar($user)
        ]);
    }

    public function updateProfile(Request $request) {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'min:2|max:36',
            'new_display_name' => 'min:3|max:16',
            'bio' => 'max:256',
            'pronouns' => 'max:15',
            'avatar' => 'image|nullable'
        ]);

        //If a new avatar image is passed, change the profile photo
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            self::changeProfilePhoto($user, $image);
        }

        $newName = $request->input('name') ?? $user->getName();
        $newBio = $request->input('bio') ?? $user->getBio();
        $newUserName = $request->input('new_display_name') ?? $user->getDisplayName();
        $newVirginStatus = $request->input('virgin_status') ?? $user->getVirginStatus();
        $newPronouns = $request->input('pronouns') ?? $user->getPronouns();

        $user->update([
            'name' => $newName, 
            'bio' => $newBio, 
            'virgin_status' => $newVirginStatus,
            'pronouns' => $newPronouns
        ]);
        
        if($user->changeDisplayName($newUserName)) {
            return redirect()->route('dash', ['id' => $user->getDisplayName()])
                ->with(['success' => 'Profile Updated!']);
        } else {
            return back()->withErrors(['username taken' => 'this username is not available!']);
        }

    }

    public function deleteUser(Request $request) {
        $user = Auth::user();
        $tattoos = Tattoo::where('user_id', '=', $user->getId())->get();

        if(File::exists('/public/users/' . $user->getStorageDir())) {
            dd("yo");
        }

        //remove tattoo rows
        foreach($tattoos as $tattoo) {
            //$tattoo->delete();
        }
    }

    private static function changeProfilePhoto($user, $image) {
        //I hate this but whatever
        //path were storing the image
        $userPath = '/public/users/' . $user->getStorageDir() . '/avatars/';
        //path to access the old image
        $oldAvatar = './storage/users/' . $user->getStorageDir() . '/avatars/' . $user->getAvatar();
        //remove the old image
        if (File::exists($oldAvatar)) {
            unlink($oldAvatar);
        } 
        //get attributes of image
        $newAvatar = $image->getClientOriginalName();
        $fileName = pathinfo($newAvatar, PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        //create new unique file name
        $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
        //store image
        $image->storeAs($userPath, $fileNameToStore);
        $user->update(['avatar' => $fileNameToStore]);
    }
}
