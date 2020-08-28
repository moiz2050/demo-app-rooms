<?php

namespace App\Integrations\Advertisers;

use App\Integrations\Advertisers\Airbnb\Adapter\AirbnbServiceAdapter;
use App\Integrations\Advertisers\Cuddlynest\Adapter\CuddlynestServiceAdapter;
use App\Integrations\Advertisers\Airbnb\Client as AirbnbClient;
use App\Integrations\Advertisers\Cuddlynest\Client as CuddlynestClient;
use App\Integrations\Advertisers\Cuddlynest\Transformer as CuddlynestTransformer;
use App\Integrations\Advertisers\Airbnb\Transformer as AirbnbTransformer;
use InvalidArgumentException;

class AdvertisersServiceManager implements Factory
{
    public function service($name)
    {
        return $this->resolve($name);
    }

    protected function getConfig($name)
    {
        return config("advertisers.{$name}");
    }

    /**
     * Resolve the given service.
     *
     * @param string $name
     *
     * @return AdvertisersServiceAdapterInterface
     * @throws InvalidArgumentException
     */
    protected function resolve($name): AdvertisersServiceAdapterInterface
    {
        $config = $this->getConfig($name);

        if (empty($config['endPoint'])) {
            throw new InvalidArgumentException("Advertiser [{$name}] does not exist.");
        }

        $driverMethod = 'create'.ucfirst($name).'Service';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config);
        } else {
            throw new InvalidArgumentException("Advertiser [{$name}] is not supported.");
        }
    }

    /**
     * @param $config
     *
     * @return AdvertisersServiceAdapterInterface
     */
    protected function createAirbnbService($config)
    {
        return new AirbnbServiceAdapter(new AirbnbClient($config['endPoint']), new AirbnbTransformer());
    }

    /**
     * @param $config
     *
     * @return AdvertisersServiceAdapterInterface
     */
    protected function createCuddlynestService($config)
    {
        return new CuddlynestServiceAdapter(new CuddlynestClient($config['endPoint']), new CuddlynestTransformer());
    }
}
