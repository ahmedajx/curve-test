<?php

namespace App\Services;

use GuzzleHttp\Client;

class ExchangeService
{
    private $client;

    /**
     * ExchangeService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $base
     * @param string $startDate
     * @param string $endDate
     * @return string
     */
    public function getLatestExchangeRate(string $base, string $startDate, string $endDate): string
    {
        return $this->client->get("https://api.exchangeratesapi.io/history?start_at=".$startDate."&end_at=". $endDate ."&base=". $base ."&symbols=EUR")->getBody()->getContents();
    }
}
