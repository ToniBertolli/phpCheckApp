<?php

namespace App\Helpers\ProcedureStrategy;

use App\Models\Log;
use App\Models\Procedure;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use function MongoDB\BSON\toJSON;

class RequestStrategy implements IProcedureStrategy
{
    public function process(Client $client, Procedure $procedure, Log $log)
    {
//        $log = new Log;

        $resp = $client->head($procedure->endpoint->url, [
            'headers' => [
                'x-api-version' => '2',
                'Accept' => 'application/json',
                'connect_timeout' => 10
            ],
            'on_stats' => function (TransferStats $stats) use ($log) {
                $log->response_time = $stats->getTransferTime();
            },
            'verify' => false
        ]);
        return $resp;
    }
}
