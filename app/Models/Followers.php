<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Auth;

class Followers extends Model {

    protected $table = 'followers';

    protected $fillable = ['follower_user_id', 'followee_user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
