<?php

namespace App\Services\Advertisers;

use App\Facades\Advertiser;

class HubService implements HubServiceInterface
{
    public function getRooms(): array
    {
        $hotels = $this->getHotelsFromServices();

        $rooms = $this->filterHotelRooms($hotels);

        return ['rooms' => $rooms];
    }

    /**
     * Return a flat array of all hotels from all services
     *
     * @return array
     */
    private function getHotelsFromServices(): array
    {
        return collect(config('advertisers.enabled'))->flatMap(function ($service) {
            $serviceResponse = Advertiser::service($service)->getData();

            if (!isset($serviceResponse->hotels)) {
                return [];
            }
            return collect($serviceResponse->hotels)->map(function ($hotel) {
                return $hotel;
            });
        })->all();
    }

    /**
     * Filter duplicate room types in same hotel and get uniques rooms from all hotels
     *
     * @param array $hotels
     *
     * @return array
     */
    private function filterHotelRooms(array $hotels): array
    {
        $hotelsTempArray = [];
        $roomsTempArray = [];

        foreach ($hotels as $hotel) {
            if (!isset($hotelsTempArray[$hotel->name])) {
                $hotelsTempArray[$hotel->name] = $hotel;
                continue;
            }

            foreach ($hotelsTempArray[$hotel->name]->rooms as $firstHotelRoom) {
                foreach ($hotel->rooms as $otherHotelRoom) {
                    if ($otherHotelRoom->code === $firstHotelRoom->code) {
                        if ($firstHotelRoom->totalPrice <= $otherHotelRoom->totalPrice) {
                            $roomsTempArray[$otherHotelRoom->code] = $firstHotelRoom;
                        }
                    } else {
                        if (!isset($roomsTempArray[$otherHotelRoom->code])) {
                            $roomsTempArray[$otherHotelRoom->code] = $otherHotelRoom;
                        }

                        if (!isset($roomsTempArray[$firstHotelRoom->code])) {
                            $roomsTempArray[$firstHotelRoom->code] = $firstHotelRoom;
                        }
                    }
                }
            }

            $hotelsTempArray[$hotel->name]->rooms = collect($roomsTempArray)->all();
            unset($roomsTempArray);
        }

        return collect($hotelsTempArray)->flatMap(function ($hotel) {
            $hotelName = $hotel->name;
            return collect($hotel->rooms)->map(function ($room) use ($hotelName) {
                $roomArray = (array)$room;
                $roomArray['hotelName'] = $hotelName;
                return (object)$roomArray;
            });
        })->sortBy('totalPrice')->values()->all();
    }
}
