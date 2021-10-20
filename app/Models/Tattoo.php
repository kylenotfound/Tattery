<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tattoo extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'tattoo_image_name',
    ];

    public function user() {
        $this->belongsTo(User::class, 'user_id');
    }

    public function getTattooImageName() {
        return $this->tattoo_image_name;
    }

}
