<?php

namespace App\Models;

use App\Enums\FieldType;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'type', 'handle', 'value', 'procedure_id'
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function typeEquals($type) {
        return $this->attributes['type'] == FieldType::getKey($type);
    }

    public function valueEquals($data)
    {
        return strpos($data, $this->attributes['value']) ? true : false;
    }
}
