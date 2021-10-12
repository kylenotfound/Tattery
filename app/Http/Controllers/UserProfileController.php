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

    public function updateName($newName) {

    }

    public function updateDisplayName(Request $request) {
        $user = Auth::user();

        $validatedName = $request->validate([
            'new_display_name' => 'required|max:16|min:3'
        ]);

        $newDisplayName = $request->input('new_display_name');
        
        if($user->changeDisplayName($newDisplayName)) {
            return redirect()->route('dash', ['id' => $user->getDisplayName()])
                ->with(['success' => 'successfully updated your username!']);
        };

        return back()->withErrors(['name already taken' => 'this username is not available!']);
    }

    public function updateBio($newBio) {

    }
}
