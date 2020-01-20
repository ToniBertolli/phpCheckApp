<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'code', 'reason', 'procedure_id'
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
