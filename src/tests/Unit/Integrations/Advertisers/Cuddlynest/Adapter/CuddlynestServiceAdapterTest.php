<?php
namespace Tests\Unit\Integrations\Advertisers\Cuddlynest\Adapter;

use App\Integrations\Advertisers\Cuddlynest\Adapter\CuddlynestServiceAdapter;
use App\Integrations\Advertisers\Cuddlynest\Client;
use App\Integrations\Advertisers\Cuddlynest\Transformer;
use Tests\TestCase;

class CuddlynestServiceAdapterTest extends TestCase
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
     * @var CuddlynestServiceAdapter
     */
    private CuddlynestServiceAdapter $cuddlynestServiceAdapter;

    public function setUp(): void
    {
        $this->clientMock = \Mockery::mock(Client::class);
        $this->transformerMock = \Mockery::mock(Transformer::class)->makePartial();

        $this->cuddlynestServiceAdapter = new CuddlynestServiceAdapter($this->clientMock, $this->transformerMock);
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
                                'code' => 'DBL-TWN',
                                'name' => "Double or Twin SUPERIOR",
                                'netPrice' => "143.00",
                                'taxes' => [
                                    'amount' => '10.00',
                                    'currency' => 'EUR',
                                    'type' => 'TAXESANDFEES'
                                ],
                                'totalPrice' => '153.00'
                            ]
                        ]
                    ]
                ]
            ]);

        $data = $this->cuddlynestServiceAdapter->getData();

        $this->assertEquals((object)[
            'hotels' => [
                (object)[
                    'name' => 'hotelA',
                    'stars' => 4,
                    'rooms' => [
                        (object)[
                            'code' => 'DBL-TWN',
                            'name' => "Double or Twin SUPERIOR",
                            'netPrice' => "143.00",
                            'taxes' => [
                                'amount' => '10.00',
                                'currency' => 'EUR',
                                'type' => 'TAXESANDFEES'
                            ],
                            'totalPrice' => '153.00'
                        ]
                    ]
                ]
            ]
        ], $data);
    }

    public function getDataSource()
    {
        return [
            [(object)[
            'hotels' => [
                (object)[
                    'name' => 'hotelA',
                    'stars' => 4,
                    'rooms' => [
                        (object)[
                            'code' => 'DBL-TWN',
                            'name' => "Double or Twin SUPERIOR",
                            'net_rate' => "143.00",
                            'taxes' => [
                                'amount' => '10.00',
                                'currency' => 'EUR',
                                'type' => 'TAXESANDFEES'
                            ],
                            'totalPrice' => '153.00'
                        ]
                    ]
                ]
            ]
        ]]
        ];
    }

}
