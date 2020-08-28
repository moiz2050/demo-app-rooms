<?php

namespace App\Integrations\Advertisers\Cuddlynest;

use App\Integrations\Advertisers\TransformerInterface;

class Transformer implements TransformerInterface
{
    public function parse(\stdClass $data)
    {
        return (object) collect($data)->each(function ($hotels) {
            collect($hotels)->each(function ($hotel) {
                $hotel->rooms = collect($hotel->rooms)->map(function ($room) {
                    return (object) [
                        'code' => $room->code,
                        'name' => $room->name,
                        'netPrice' => $room->net_rate,
                        'taxes' => $room->taxes,
                        'totalPrice' => $room->totalPrice,
                    ];
                })->sortBy('totalPrice')->all();
            });
        })->all();
    }
}
