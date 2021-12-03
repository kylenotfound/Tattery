<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\Helpers;

use App\Models\Tattoo;
use App\Models\Likes;
use App\Models\User;
use Auth;

class LikeController extends Controller {

    public function like($id) {
        //Find the tattoo to be liked. 404 if it doesnt exist
        $tattoo = Tattoo::findOrFail($id);
        $user = auth()->user();

        $user->like($tattoo);

        return response()->json([
            'count' => $tattoo->getNumOfLikes()
        ]);
    }

    public function unlike($id) {
        //Find the tattoo to be unliked. 404 if it doesnt exist
        $tattoo = Tattoo::findOrFail($id);
        $user = auth()->user();

        $user->unlike($tattoo);

        $totalLikesOnTattoo = $tattoo->likes;

        return response()->json([
            'count' => $tattoo->getNumOfLikes()
        ]);
    }

}
