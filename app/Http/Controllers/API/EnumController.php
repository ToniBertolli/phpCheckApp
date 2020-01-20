<?php

namespace App\Http\Controllers\API;

use App\Enums\FieldType;
use App\Http\Controllers\Controller;
use App\Enums\ProcedureType;

class EnumController extends Controller
{
    public function procedureTypes()
    {
        return ProcedureType::getInstances();
    }

    public function fieldTypes()
    {
        return FieldType::getInstances();
    }
}
