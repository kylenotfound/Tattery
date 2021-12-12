<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Helpers;
use App\Models\Tattoo;
use App\Models\Follow;
use App\Models\User;
use App\Models\Like;
use File;
use Auth;

class UserController extends Controller {

    public function index($id) {
        $user = User::where('display_name', '=', $id)->first();
        $tattoos = Tattoo::where('user_id', '=', $user->getId())->orderBy('created_at', 'desc')->paginate(10);
        if ($user == null) {
            return view('home')->withErrors(['user not found' => 'user does not exist']);
        }
        return view('dash', [
            'user' => $user,
            'avatar' => Helpers::getUserAvatar($user),
            'tattoos' => $tattoos
        ]);
    }

    public function updateProfile(Request $request) {
        $user = Auth::user();

        $request->validate([
            'name' => 'min:2|max:36',
            'new_display_name' => 'min:3|max:16',
            'bio' => 'max:256|nullable',
            'pronouns' => 'max:15|nullable',
            'avatar' => 'image|nullable',
            'age' => 'integer|nullable'
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
        $newAge = $request->input('age') ?? $user->getAge();

        $user->update([
            'name' => $newName,
            'bio' => $newBio,
            'virgin_status' => $newVirginStatus,
            'pronouns' => $newPronouns,
            'age' => $newAge
        ]);

        if($user->changeDisplayName($newUserName)) {
            return redirect()->route('dash', ['id' => $user->getDisplayName()])
                ->with(['success' => 'Profile Updated!']);
        } else {
            return back()->withErrors(['username taken' => 'this username is not available!']);
        }

    }

    public function deleteUser(Request $request) {
        $user = auth()->user();
        $tattoos = $user->tattoos;

        self::deleteUserContent($user, $tattoos);

        //logout the user and delete them!
        Auth::logout();
        $user->delete();

        return redirect('/')->with(['success' => 'Your profile has been erased, never to be seen again!']);

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

    private static function deleteUserContent($user, $tattoos) {

        //Check the public tattoos storage dir exists
        if (File::exists('./storage/tattoos')) {
            //get all the uploads in the storage dir
            $uploads = File::files('./storage/tattoos');
            //foreach upload in the storage dir
            foreach ($uploads as $upload) {
                //foreach tattoo row associated with the user at hand,
                foreach($tattoos as $tattoo) {
                    //if the names of the photo in the db match the photo name in the tattoos folder, remove it
                    if (basename($upload) == $tattoo->getTattooImageName()) {
                        File::delete($upload);
                    }
                }
            }
        }
        //check the user's dir exists
        if (File::exists('./storage/users/' . $user->getStorageDir())) {
            //remove avatar from storage and then delete avatar dir
            if (File::exists('./storage/users/' . $user->getStorageDir() . '/avatars/')) {
                $avatar = './storage/users/' . $user->getStorageDir() . '/avatars/' . $user->getAvatar();
                //dd($avatar);
                //there will only ever be one avatar in the avatars folder because the old avatar is removed when the profile is updated
                if(File::exists($avatar)) {
                    File::delete($avatar);
                }
                rmdir('./storage/users/' . $user->getStorageDir() . '/avatars/');
            }

            if (File::exists('./storage/users/' . $user->getStorageDir() . '/uploads/')) {
                $uploads = File::files('./storage/users/' . $user->getStorageDir() . '/uploads/');
                //loop through each upload and remove it from the uploads dir
                foreach($uploads as $upload) {
                    File::delete($upload);
                }
                rmdir('./storage/users/' . $user->getStorageDir() . '/uploads/');
            }

            rmdir('./storage/users/' . $user->getStorageDir());
        }
    }
}
