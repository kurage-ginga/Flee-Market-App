<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

        protected $fillable = [
        'user_id',
        'zipcode',
        'address',
        'building',
    ];

    public function insertUserProfile($userId, $userName, $zipcode, $address, $building)
    {
        return $this->create([
            'user_id' => $userId,
            'username' => $usename,
            'zipcode' => $zipcode,
            'address' => $address,
            'building' => $building,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
