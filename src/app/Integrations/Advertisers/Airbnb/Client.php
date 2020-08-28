<?php

namespace App\Integrations\Advertisers\Airbnb;

use App\Integrations\Advertisers\ClientAbstract;

class Client extends ClientAbstract
{
    public function getHotels(): object
    {
        try {
            return json_decode($this->httpClient->get($this->endPoint)->getBody()->getContents());
        } catch (\Exception $exception) {
            return (object)[];
        }
    }
}
