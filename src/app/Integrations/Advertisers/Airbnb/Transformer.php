<?php

namespace App\Integrations\Advertisers\Airbnb;

use App\Integrations\Advertisers\TransformerInterface;

class Transformer implements TransformerInterface
{
    /**
     * @param \stdClass $data
     *
     * @return object
     */
    public function parse(\stdClass $data): object
    {
        return (object) collect($data)->each(function ($hotels) {
            collect($hotels)->each(function ($hotel) {
                $hotel->rooms = collect($hotel->rooms)->map(function ($room) {
                    return (object) [
                        'code' => $room->code,
                        'name' => '',
                        'netPrice' => $room->net_price,
                        'taxes' => $room->taxes,
                        'totalPrice' => $room->total,
                    ];
                })->sortBy('totalPrice')->all();
            });
        })->all();
    }
}
