<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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

    public function updateProfile(Request $request) {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'min:2|max:36',
            'new_display_name' => 'min:3|max:16',
            'bio' => 'max:256',
            'pronouns' => 'max:15'
        ]);

        $newName = $request->input('name') ?? $user->getName();
        $newBio = $request->input('bio') ?? $user->getBio();
        $newUserName = $request->input('new_display_name') ?? $user->getDisplayName();
        $newVirginStatus = $request->input('virgin_status') ?? $user->getVirginStatus();
        $newPronouns = $request->input('pronouns') ?? $user->getPronounds();

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
}
