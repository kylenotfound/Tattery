<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Likes;

class Tattoo extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'tattoo_image_name', 'description', 'location'
    ];

    public function getId() {
        return $this->id;
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes() {
        return $this->hasMany(Likes::class);
    }

    public function getTattooImageName() {
        return $this->tattoo_image_name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getNumOflikes() {
        return count($this->likes);
    }

}
