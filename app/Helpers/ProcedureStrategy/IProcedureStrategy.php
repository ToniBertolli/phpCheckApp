<?php

namespace App\Helpers\ProcedureStrategy;

use App\Models\Log;
use App\Models\Procedure;
use GuzzleHttp\Client;

interface IProcedureStrategy
{
    public function process(Client $client, Procedure $procedure, Log $log);
}
