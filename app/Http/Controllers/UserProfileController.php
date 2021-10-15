<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use File;
use Auth;

class UserProfileController extends Controller {
    
    public function index($id) {
        $user = User::where('display_name', '=', $id)->first();
        if ($user == null) {
            return view('welcome')->withErrors(['user not found' => 'user does not exist']);
        }
        //dd(File::exists(storage_path() . '/app/public/users/' . $user->getStorageDir() . '/' . $user->getAvatar()));
        return view('dash', [
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request) {
        //dd($request->all());
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'min:2|max:36',
            'new_display_name' => 'min:3|max:16',
            'bio' => 'max:256'
        ]);

        if ($request->hasFile('avatar')) {
            //Get the user's upload path
            $userPath = '/public/users/' . $user->getStorageDir() . '/avatars/';
            $oldAvatar = $userPath . '/' . $user->getAvatar();
            $newAvatar = $request->file('avatar')->getClientOriginalName();
            $fileName = pathinfo($newAvatar, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $request->file('avatar')->storeAs($userPath, $fileNameToStore);
            $user->updateAvatar($fileNameToStore);
        }

        $newName = $request->input('name') ?? $user->getName();
        $newBio = $request->input('bio') ?? $user->getBio();
        $newUserName = $request->input('new_display_name') ?? $user->getDisplayName();
        $newVirginStatus = $request->input('virgin_status') ?? $user->getVirginStatus();

        $user->updateName($newName);
        $user->updateBio($newBio);
        $user->updateVirginStatus($newVirginStatus);
        
        if($user->changeDisplayName($newUserName)) {
            return redirect()->route('dash', ['id' => $user->getDisplayName()])
                ->with(['success' => 'Profile Updated!']);
        } else {
            return back()->withErrors(['username taken' => 'this username is not available!']);
        }

    }
}
