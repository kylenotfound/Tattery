<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\Helpers;

use App\Models\Tattoo;
use App\Models\User;
use Auth;

class LikeController extends Controller {

    public function like($id) {
        //Find the tattoo to be liked. 404 if it doesnt exist
        $tattoo = Tattoo::findOrFail($id);
        $user = auth()->user();

        $user->like($tattoo);
        $totalLikesOnTattoo = Helpers::likes($tattoo);

        return response()->json([
            'liked' => 'liked',
            'count' => $totalLikesOnTattoo
        ]);
    }

    public function unlike($id) {
        //Find the tattoo to be unliked. 404 if it doesnt exist
        $tattoo = Tattoo::findOrFail($id);
        $user = auth()->user();

        $user->unlike($tattoo);
        $totalLikesOnTattoo = Helpers::likes($tattoo);

        return response()->json([
            'liked' => 'unliked',
            'count' => $totalLikesOnTattoo
        ]);
    }

}
