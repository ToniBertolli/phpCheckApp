<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected $fillable = [
        'name', 'url', 'status', 'instance_id'
    ];

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }
}
