<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Like;
use App\Models\Follow;
use App\Models\Tattoo;
use Auth;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'external_id', 'name', 'display_name', 'email', 'password', 'avatar', 'pronouns', 'bio', 'virgin_status', 'unique_storage_dir', 'age'
    ];

    protected $hidden = ['password', 'remember_token'];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tattoos() {
        return $this->hasMany(Tattoo::class);
    }

    /**
     * follower_user_id corresponds to a user that is a follower of many other users
     * therefore following() returns all of the users $this user is a follower of.
     *
     * followee_user_id corresponds to the user that a user is following
     * therefore a user is the followee to many other users.
     *
     * We include the whereNull('deleted_at') to ignore trashed records
     */

    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'followee_user_id', 'follower_user_id')->whereNull('deleted_at');
    }


    public function following() {
        return $this->belongsToMany(User::class, 'follows', 'follower_user_id', 'followee_user_id')->whereNull('deleted_at');
    }

    public function likes() {
        return $this->hasMany(Like::class, 'likers_user_id');
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDisplayName() {
        return $this->display_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getBio() {
        return $this->bio;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getStorageDir() {
        return $this->unique_storage_dir;
    }

    public function getVirginStatus() {
        return $this->virgin_status;
    }

    public function getPronouns() {
        return $this->pronouns;
    }

    public function getAge() {
        return $this->age;
    }

    /**
     * Mutator functions
     */
    public function changeDisplayName($newDisplayName) {
        //If the display name we are updating doesn't belong to another user
        if(User::where('display_name', '=', $newDisplayName)->exists() && !$this) {
            return false;
        } else {
            $this->display_name = $newDisplayName;
            $this->save();
            $this->refresh();
            return true;
        }
    }

    public function like(Tattoo $tattoo) {
        //need to use first() because get() returns collection
        $like = Like::where('likers_user_id', '=', $this->getId())
            ->where('tattoo_id', '=', $tattoo->getId())
            ->withTrashed()
            ->first();

        //if a like exists, restore it
        if($like != null) {
            $like->restore();
            return true;
        }

        $like = new Like;
        $like->likers_user_id = $this->getId();
        $like->tattoo_id = $tattoo->getId();
        $like->save();

        return true;
    }

    public function unlike(Tattoo $tattoo) {
        $like = Like::where('likers_user_id', '=', $this->getId())
            ->where('tattoo_id', '=', $tattoo->getId());

        if ($like == null) {
            return false;
        }

        $like->delete();

        return true;
    }

    public function isLiking(Tattoo $tattoo) {
        $like = Like::where('likers_user_id', '=', $this->getId())
            ->where('tattoo_id', '=', $tattoo->getId())
            ->exists();

        if($like == null) {
            return false;
        }

        return true;
    }

    public function getAllLikes() {
        $tattoos = Tattoo::where('user_id', '=', $this->getId())->get();
        if (count($tattoos) <= 0) {
            return 0;
        }

        $sum = 0;
        foreach($tattoos as $tattoo) {
            $sum += count($tattoo->likes);
        }

        return $sum;
    }

    public function follow(User $userWeAreFollowing) {

        $follow = Follow::withTrashed()
            ->where('follower_user_id', $this->getId())
            ->where('followee_user_id', $userWeAreFollowing->getId())
            ->first();

        if ($follow != null) {
            $follow->restore();
            return true;
        }

        $follow = new Follow;
        $follow->follower_user_id = $this->getId(); //$this user is a new follower
        $follow->followee_user_id = $userWeAreFollowing->getId(); //the user we are following is the followee
        $follow->save();

        return true;
    }

    public function unfollow(User $userWeAreUnFollowing) {
        if(!$this->isFollowing($userWeAreUnFollowing)) {
            return false;
        }

        $follow = Follow::where('follower_user_id', $this->getId())
            ->where('followee_user_id', $userWeAreUnFollowing->getId());

        if ($follow == null) {
            return false;
        }

        $follow->delete();
        return true;
    }

    public function isFollowing(User $followee) {
        //checking if $this user is a follower of the $followee
        $follow = Follow::where('follower_user_id', $this->getId())
            ->where('followee_user_id', $followee->getId())->first();

        if ($follow == null) {
            return false;
        }

        return true;
    }
}
