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

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'external_id', 'name', 'display_name', 'email', 'password', 'avatar', 'pronouns', 'bio', 'virgin_status', 'unique_storage_dir', 'age'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Accessor functions
     */
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

    public function tattoos() {
        return $this->hasMany(Tattoo::class);
    }

    public function followers() {
        return $this->hasMany(Follow::class, 'follower_user_id');
    }

    public function following() {
        return Follow::where('followee_user_id', '=', $this->getId())->get();
    }

    public function like(Tattoo $tattoo) {
        $like = Like::where('likers_user_id', '=', $this->id)
            ->where('tattoo_id', '=', $tattoo->id)
            ->get();

        if (count($like) != 0) {
            return false;
        }

        $like = new Like;
        $like->likers_user_id = $this->id;
        $like->tattoo_id = $tattoo->id;
        $like->save();

        return true;
    }

    public function unlike(Tattoo $tattoo) {
        $like = Like::where('likers_user_id', '=', $this->id)
            ->where('tattoo_id', '=', $tattoo->id);

        if ($like == null) {
            return false;
        }

        $like->delete();

        return true;
    }

    public function isLiking(Tattoo $tattoo) {
        $like = Like::where('likers_user_id', '=', $this->id)
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
        //If the user is already following the user and they try to follow again
        if ($this->isFollowing($userWeAreFollowing)) {
            return false;
        }

        $follow = new Follow;
        $follow->follower_user_id = $userWeAreFollowing->getId();
        $follow->followee_user_id = $this->getId();
        $follow->save();

        return true;
    }

    public function unfollow(User $userWeAreUnFollowing) {
        if(!$this->isFollowing($userWeAreUnFollowing)) {
            return false;
        }

        $follow = Follow::where('follower_user_id', '=', $userWeAreUnFollowing->getId())
            ->where('followee_user_id', '=', $this->getId());
        
        if ($follow == null) {
            return false;
        }

        $follow->delete();
        return true;
    }

    public function isFollowing(User $user1) {;
        $follow = Follow::where('follower_user_id', '=', $user1->getId())
            ->where('followee_user_id', '=', $this->getId())->exists();

        if ($follow == null) {
            return false;
        }

        return true;
    }
}
