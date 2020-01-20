<?php

namespace App\Helpers\ProcedureStrategy;

use App\Models\Log;
use App\Models\Procedure;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

class BodyStrategy implements IProcedureStrategy
{
    public function process(Client $client, Procedure $procedure, Log $log)
    {
//        $log = new Log;
        $resp = $client->request('GET', $procedure->endpoint->url, [
            'headers' => [
                'x-api-version' => '2',
                'Accept'        => 'application/json',
                'connect_timeout' => 20
            ],
            'on_stats' => function (TransferStats $stats) use ($log) {
                $log->response_time = $stats->getTransferTime();
            }
        ]);

        foreach ($procedure->fields as $field)
        {
            if (!$field->valueEquals($resp->getBody())) {
                throw new \Exception('Unprocessable Entity (body content was not found)', 422);
            }
        }

        return $resp;
    }
}
