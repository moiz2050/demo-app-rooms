<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetRoomsApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessResponse()
    {
        $response = $this->get('/api/rooms');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'data' => [
                'rooms' => [
                    '*' => [
                        'code',
                        'name',
                        'netPrice',
                        'taxes',
                        'totalPrice',
                        'hotelName'
                    ]
                ]
            ]
        ]);
    }
}
