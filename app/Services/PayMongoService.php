<?php

namespace App\Services;

use GuzzleHttp\Client;

class PayMongoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.paymongo.com/v1/',
            'auth' => [env('PAYMONGO_SECRET_KEY'), '']
        ]);
    }

    public function getPayments()
    {
        $response = $this->client->request('GET', 'payments');
        $payments = json_decode($response->getBody(), true);

        return $payments['data'];
    }
}
