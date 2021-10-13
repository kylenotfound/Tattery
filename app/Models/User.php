<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'external_id', 'name', 'display_name', 'email', 'password', 'avatar', 'bio', 'virgin_status', 'unique_storage_dir'
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

    /**
     * Mutator functions
     */
    public function updateName($newName) {
        $this->name = $newName;
        $this->save();
    }

    public function changeDisplayName($newDisplayName) {
        //If the display name we are updating doesn't belong to another user 
        if(User::where('display_name', '=', $newDisplayName)->exists() || !$this) {
            return false;
        } else {
            $this->display_name = $newDisplayName;
            $this->save();
            $this->refresh();
            return true;
        }
    }

    public function updateBio($newBio) {
        $this->bio = $newBio;
        $this->save();
    }

    public function updateVirginStatus($newStatus) {
        $this->virgin_status = $newStatus;
        $this->save();
    }

}
