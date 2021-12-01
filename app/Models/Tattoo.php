<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\Befriended\Traits\CanBeLiked;
use Rennokki\Befriended\Contracts\Likeable;
use App\Models\User;

class Tattoo extends Model implements Likeable {
    use HasFactory, CanBeLiked;

    protected $fillable = [
        'user_id', 'tattoo_image_name', 'description', 'location'
    ];

    public function getId() {
        return $this->id;
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
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

}
