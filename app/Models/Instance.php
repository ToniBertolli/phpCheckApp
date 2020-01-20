<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    protected $fillable = [
        'name', 'logo', 'user_id'
    ];

    public function endpoints()
    {
        return $this->hasMany(Endpoint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
