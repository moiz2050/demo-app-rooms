<?php

namespace App\Facades;

use App\Integrations\Advertisers\AdvertisersServiceAdapterInterface;
use Illuminate\Support\Facades\Facade;


/**
 * @method static AdvertisersServiceAdapterInterface service(string $name)
 */

class Advertiser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'advertiser';
    }
}
