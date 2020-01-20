<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $fillable = [
        'status', 'code', 'endpoint_id', 'type', 'data', 'response_time', 'interval'
    ];

    public function endpoint()
    {
        return $this->belongsTo(Endpoint::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function isChanged($code, $status)
    {
        if($this->code === null || $this->code != $code || $this->status != $status){
            return true;
        }
        return false;
    }
}
