<?php

namespace Ivanstan\Tle;

use GuzzleHttp\Client;
use Ivanstan\Tle\Model\Tle;

class Api
{
    private const ENDPOINT = 'https://data.ivanstanojevic.me';

    private Client $client;

    public function __construct(Client $client = null)
    {
        if ($client === null) {
            $client = new Client();
        }

        $this->client = $client;
    }

    public function get(int $id): Tle
    {
        $response = $this->client->get(
            self::ENDPOINT . '/api/tle/' . $id
            ,
            [
                'query' => [
                    'id' => $id,
                ],
            ]
        );

        $record = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return new Tle($record['line1'], $record['line2'], $record['name']);
    }
}