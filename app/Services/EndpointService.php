<?php

namespace App\Services;

use App\Models\Endpoint;

class EndpointService
{
    private $endpoint;

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function process()
    {
        foreach ($this->endpoint->procedures as $endpointProcedure) {
            $procedureService = new ProcedureService($endpointProcedure);
            $procedureService->process();

        }
    }
}
