<?php

namespace App\Helpers\ProcedureStrategy;

use App\Enums\FieldType;
use App\Models\Field;
use App\Models\Log;
use App\Models\Procedure;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

class ApiStrategy implements IProcedureStrategy
{
    public function process(Client $client, Procedure $procedure, Log $log)
    {
        $payload = $procedure->fields->map(function (Field $field) {
            $item = [
                'name' => $field->handle,
                'contents' => $field->value,
            ];

            if ($field->typeEquals(FieldType::FILE)) {
                $item['contents'] = fopen(storage_path("app/".$item['contents']), 'r');
            }

            return $item;
        });

        $resp = $client->post($procedure->endpoint->url, [
            'headers' => [
                'x-api-version' => '2',
                'Accept'        => 'application/json',
                'connect_timeout' => 20
            ],
            'multipart' => $payload->toArray(),
            'on_stats' => function (TransferStats $stats) use ($log) {
                $log->response_time = $stats->getTransferTime();
            }
        ]);

        return $resp;
    }
}
