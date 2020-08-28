<?php
namespace App\Integrations\Advertisers\Airbnb\Adapter;

use App\Integrations\Advertisers\AdvertisersServiceAdapterInterface;
use App\Integrations\Advertisers\ClientAbstract;
use App\Integrations\Advertisers\TransformerInterface;
use Illuminate\Support\Collection;

class AirbnbServiceAdapter implements AdvertisersServiceAdapterInterface
{
    /**
     * @var ClientAbstract
     */
    public ClientAbstract $client;

    public TransformerInterface $transformer;

    public function __construct(ClientAbstract $client, TransformerInterface $transformer)
    {
        $this->client = $client;
        $this->transformer = $transformer;
    }

    /**
     * @return object
     */
    public function getData(): object
    {
        $hotels = $this->client->getHotels();
        return $this->transformer->parse($hotels);
    }
}
