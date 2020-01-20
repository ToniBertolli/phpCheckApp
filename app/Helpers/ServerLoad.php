<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class ServerLoad
{
    /**
     * Array key will be shown on front-end
     *
     * @var array
     */
    private static $endpoints = [
        'V1' => 'https://cpu.web01.valicare.nl',
        'V2' => 'https://cpu.web02.valicare.nl'
    ];

    /**
     * Retrieve server load for all servers
     *
     * @return array
     */
    public static function get()
    {
        $load = [];
        foreach (self::$endpoints as $label => $uri) {
            $load[$label] = self::getServer($uri);
        }

        return $load;
    }

    /**
     * Retrieve server load for given uri
     *
     * @param $uri
     *
     * @return int
     */
    private static function getServer($uri)
    {
        if (!$uri) {
            return 0;
        }

        $client = new Client();
        $response = $client->request('GET', $uri);
        $response = json_decode($response->getBody());

        return $response->percentage;
    }
}
