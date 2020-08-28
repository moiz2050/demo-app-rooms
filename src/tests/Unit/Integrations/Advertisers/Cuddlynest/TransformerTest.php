<?php
namespace Tests\Unit\Integrations\Advertisers\Cuddlynest;

use App\Integrations\Advertisers\Cuddlynest\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{
    /**
     * @param $dataSource
     *
     * @dataProvider dataSource
     */
    public function testGetHotels($dataSource)
    {
        $transformedData = (new Transformer())->parse($dataSource);

        $expectedOutput = (object)[
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
        ];

        $this->assertEquals($expectedOutput, $transformedData);
    }

    public function dataSource()
    {
        return [
            [
                (object)[
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
                ]
            ]
        ];
    }
}
