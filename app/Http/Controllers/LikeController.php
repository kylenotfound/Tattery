<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libraries\Helpers;

use App\Models\Tattoo;
use App\Models\User;
use Auth;

class LikeController extends Controller {

    public function like($id) {
        //TODO make this actually good
        $tattoo = Tattoo::findOrFail($id);
        $user = auth()->user();
        $user->like($tattoo);
        $totalLikesOnTattoo = Helpers::likes($user, $tattoo);
        return response()->json([
            'liked' => 1,
            'count' => $totalLikesOnTattoo
        ]);
    }

    public function unlike($id) {
        //TODO make this actually good
        $tattoo = Tattoo::findOrFail($id);
        $user = auth()->user();
        $user->unlike($tattoo);
        $totalLikesOnTattoo = Helpers::likes($user, $tattoo);
        return response()->json([
            'liked' => 0,
            'count' => $totalLikesOnTattoo
        ]);
    }
}
