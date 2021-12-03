<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tattoo;
use App\Models\User;
use Auth;

class Like extends Model {

    protected $table = 'likes';

    protected $fillable = ['likers_user_id', 'tattoo_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
