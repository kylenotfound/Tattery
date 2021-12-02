<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Auth;

class FollowController extends Controller {
    
    public function follow($id) {
        $follower = auth()->user();
        $followee = User::findOrFail($id);

        $follower->follow($followee);

        return response()->json([
            'followersCount' => $followee->followers()->count(),
            'followingCount' => $followee->following()->count(),
        ]);
    }

    public function unfollow($id) {
        $follower = auth()->user();
        $followee = User::findOrFail($id);

        $followee->revokeFollower($follower);
        
        return response()->json([
            'followersCount' => $followee->followers()->count(),
            'followingCount' => $followee->following()->count(),
        ]);
    }
}
