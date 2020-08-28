<?php
namespace Tests\Unit\Integrations\Advertisers\Airbnb\Adapter;

use App\Integrations\Advertisers\Airbnb\Adapter\AirbnbServiceAdapter;
use App\Integrations\Advertisers\Airbnb\Client;
use App\Integrations\Advertisers\Airbnb\Transformer;
use Tests\TestCase;

class AirbnbServiceAdapterTest extends TestCase
{
    /**
     * @var Client|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $clientMock;

    /**
     * @var Transformer|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $transformerMock;

    /**
     * @var AirbnbServiceAdapter
     */
    private AirbnbServiceAdapter $airbnbServiceAdapter;

    public function setUp(): void
    {
        $this->clientMock = \Mockery::mock(Client::class);
        $this->transformerMock = \Mockery::mock(Transformer::class)->makePartial();

        $this->airbnbServiceAdapter = new AirbnbServiceAdapter($this->clientMock, $this->transformerMock);
    }

    /**
     * @dataProvider getDataSource
     */
    public function testGetData($dataSource)
    {
        $this->clientMock->shouldReceive('getHotels')->andReturn(
            $dataSource
        );

        $this->transformerMock
            ->shouldReceive('parse')
            ->with($dataSource)
            ->andReturn((object)[
                'hotels' => [
                    (object)[
                    'name' => 'hotelA',
                    'stars' => 4,
                    'rooms' => [
                        (object)[
                            'code' => 'SNGRM',
                            'name' => "",
                            'netPrice' => "144",
                            'taxes' => [
                                'amount' => '14.00',
                                'currency' => 'EUR',
                                'type' => 'TAXESANDFEES'
                            ],
                            'totalPrice' => '158.00'
                        ]
                    ]
                ]
            ]
            ]);

        $data = $this->airbnbServiceAdapter->getData();

        $this->assertEquals((object)[
            'hotels' => [
                (object)[
                    'name' => 'hotelA',
                    'stars' => 4,
                    'rooms' => [
                        (object)[
                            'code' => 'SNGRM',
                            'name' => "",
                            'netPrice' => "144",
                            'taxes' => [
                                'amount' => '14.00',
                                'currency' => 'EUR',
                                'type' => 'TAXESANDFEES'
                            ],
                            'totalPrice' => '158.00'
                        ]
                    ]
                ]
            ]
        ], $data);
    }

    public function getDataSource()
    {
        return [[(object)[
            'hotels' => [
                (object)[
                    'name' => 'hotelA',
                    'stars' => 4,
                    'rooms' => [
                        (object)[
                            'code' => 'SNGRM',
                            'net_price' => "144",
                            'taxes' => [
                                'amount' => '14.00',
                                'currency' => 'EUR',
                                'type' => 'TAXESANDFEES'
                            ],
                            'total' => '158.00'
                        ]
                    ]
                ]
            ]
        ]]];
    }
}
