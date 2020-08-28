<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomsResource;
use App\Services\Advertisers\HubServiceInterface;
use Illuminate\Http\Request;

class GetHotelRoomsController extends Controller
{
    private HubServiceInterface $advertisersHubService;

    public function __construct(HubServiceInterface $hubService)
    {
        $this->advertisersHubService = $hubService;
    }

    public function __invoke(Request $request)
    {
        return new RoomsResource($this->advertisersHubService->getRooms());
    }
}
