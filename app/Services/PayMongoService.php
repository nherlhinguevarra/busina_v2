<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PayMongoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.paymongo.com/v1/',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function getPayments($limit = 10)
    {
        try {
            $response = $this->client->request('GET', "payments?limit={$limit}");
            $payments = json_decode($response->getBody(), true)['data'];
 
            return $payments;
        } catch (RequestException $e) {
            return [];
        }
    }

    public function getPayouts($limit = 10)
    {
        try {
            $response = $this->client->request('GET', "payouts?limit={$limit}");
            $payouts = json_decode($response->getBody(), true)['data'];

            return $payouts;
        } catch (RequestException $e) {
            return [];
        }
    }
}
