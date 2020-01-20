<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ProcedureType extends Enum
{
    const REQUEST = 1;
    const BODY = 2;
    const API = 3;
}
