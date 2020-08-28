<?php
namespace App\Integrations\Advertisers\Cuddlynest;

use App\Integrations\Advertisers\ClientAbstract;

class Client extends ClientAbstract
{
    public function getHotels()
    {
        try {
            return json_decode($this->httpClient->get($this->endPoint)->getBody()->getContents());
        } catch (\Exception $exception) {
            return (object)[];
        }
    }
}
