<?php
namespace Tests\Unit\Integrations\Advertisers\Airbnb;

use App\Integrations\Advertisers\Airbnb\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{
    /**
     * @param $dummyData
     *
     * @dataProvider dummyData
     */
    public function testGetHotels($dummyData)
    {
        $transformedData = (new Transformer())->parse($dummyData);

        $expectedOutput = (object)[
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
        ];

        $this->assertEquals($expectedOutput, $transformedData);
    }

    public function dummyData()
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
                ]
            ]
        ];
    }
}
