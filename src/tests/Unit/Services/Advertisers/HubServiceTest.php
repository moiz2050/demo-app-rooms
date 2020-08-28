<?php

namespace Tests\Unit\Services\Advertisers;

use App\Services\Advertisers\HubService;
use Tests\TestCase;

class HubServiceTest extends TestCase
{
    /**
     * @var HubService
     */
    private HubService $hubService;

    public function setUp(): void
    {
        parent::setUp();

        $this->hubService = new HubService();
    }


    public function testGetRooms()
    {
        $rooms = $this->hubService->getRooms();

        $this->assertIsArray($rooms);
        $this->assertArrayHasKey('rooms', $rooms);
    }


}
