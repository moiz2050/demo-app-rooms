<?php

namespace App\Integrations\Advertisers;

use GuzzleHttp\Client as HttpClient;

abstract class ClientAbstract
{
    public string $baseUri = "https://f704cb9e-bf27-440c-a927-4c8e57e3bad1.mock.pstmn.io/";

    /**
     * @var HttpClient
     */
    protected HttpClient $httpClient;

    protected string $endPoint;

    public function __construct(string $endPoint)
    {
        $config           = [
            'base_uri' => $this->baseUri,
            'headers'  => [
                'content-type' => 'application/json',
            ]
        ];
        $this->endPoint   = $endPoint;
        $this->httpClient = new HttpClient($config);
    }

    abstract public function getHotels();
}
