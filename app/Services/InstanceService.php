<?php

namespace App\Services;

use App\Models\Instance;
use App\Models\Endpoint;

class InstanceService
{
    private $instance;

    public function __construct(Instance $instance)
    {
        $this->instance = $instance;
    }

    public function process()
    {
        foreach ($this->instance->endpoints as $instanceEndpoint) {
            $endpointService = new EndpointService($instanceEndpoint);
            $endpointService->process();
        }
    }

}
