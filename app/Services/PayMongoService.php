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

            foreach ($payments as &$payment) {
                if (isset($payment['attributes']['payment_method'])) {
                    $payment['attributes']['payment_method_details'] = $this->getPaymentMethod($payment['attributes']['payment_method']);
                } else {
                    $payment['attributes']['payment_method_details'] = 'N/A';
                }
            }

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

    private function getPaymentMethod($paymentMethodId)
    {
        if (!$paymentMethodId) {
            return 'N/A';
        }

        try {
            $response = $this->client->request('GET', "payment_methods/{$paymentMethodId}");
            $paymentMethod = json_decode($response->getBody(), true)['data'];

            if ($paymentMethod['attributes']['type'] === 'card') {
                return strtoupper($paymentMethod['attributes']['details']['brand']) . ' ending in ' . $paymentMethod['attributes']['details']['last4'];
            } else {
                return ucfirst($paymentMethod['attributes']['type']);
            }
        } catch (RequestException $e) {
            return 'N/A';
        }
    }
}
