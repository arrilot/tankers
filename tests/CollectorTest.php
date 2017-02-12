<?php

namespace Arrilot\Tests\Collectors;

use Arrilot\Tests\Collectors\Stubs\FooCollector;
use PHPUnit_Framework_TestCase;

class CollectorTest extends PHPUnit_Framework_TestCase
{
    public function test_it_can_fill_a_basic_collection()
    {
        $tanker = new FooCollector();
        $collection = [
          [
              'file' => 2,
          ],
          [
              'file' => 1,
          ],
        ];

        $tanker->collection($collection)->fields('file')->fill();

        $expected = [
            [
                'file'      => 2,
                'file_data' => [
                    'id'  => 2,
                    'foo' => 'bar',
                ],
            ],
            [
                'file'      => 1,
                'file_data' => [
                    'id'  => 1,
                    'foo' => 'bar',
                ],
            ],
        ];

        $this->assertEquals($expected, $collection);
    }

    public function test_it_can_fill_a_basic_collection_using_suffix()
    {
        $tanker = new FooCollector();
        $collection = [
            [
                'file' => 2,
            ],
            [
                'file' => 1,
            ],
        ];

        $tanker->setSuffix('_DATA');
        $tanker->collection($collection)->fields('file')->fill();

        $expected = [
            [
                'file'      => 2,
                'file_DATA' => [
                    'id'  => 2,
                    'foo' => 'bar',
                ],
            ],
            [
                'file'      => 1,
                'file_DATA' => [
                    'id'  => 1,
                    'foo' => 'bar',
                ],
            ],
        ];

        $this->assertEquals($expected, $collection);
    }

    public function test_it_can_fill_a_collection_with_empty_or_null_field()
    {
        $tanker = new FooCollector();
        $collection = [
            [
                'file' => 2,
            ],
            [
                'file' => '',
            ],
            [
                'file' => null,
            ],
        ];

        $tanker->collection($collection)->fields('file')->fill();

        $expected = [
            [
                'file'      => 2,
                'file_data' => [
                    'id'  => 2,
                    'foo' => 'bar',
                ],
            ],
            [
                'file'      => '',
                'file_data' => [],
            ],
            [
                'file'      => '',
                'file_data' => [],
            ],
        ];

        $this->assertEquals($expected, $collection);
    }

    public function test_it_can_fill_a_collection_with_multivalue_fields()
    {
        $tanker = new FooCollector();
        $collection = [
            [
                'file' => 2,
            ],
            [
                'file' => [3, 4],
            ],
        ];

        $tanker->collection($collection)->fields('file')->fill();

        $expected = [
            [
                'file'      => 2,
                'file_data' => [
                    'id'  => 2,
                    'foo' => 'bar',
                ],
            ],
            [
                'file'      => [3, 4],
                'file_data' => [
                    3 => [
                        'id'  => 3,
                        'foo' => 'bar',
                    ],
                    4 => [
                        'id'  => 4,
                        'foo' => 'bar',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $collection);
    }

    public function test_it_can_fill_a_collection_with_multiple_fields()
    {
        $tanker = new FooCollector();
        $collection = [
            [
                'file'  => 2,
                'file2' => 3,
            ],
            [
                'file'  => [3, 4],
                'file2' => [1, ''],
            ],
        ];

        $tanker->collection($collection)->fields('file', 'file2')->fill();

        $expected = [
            [
                'file'      => 2,
                'file2'     => 3,
                'file_data' => [
                    'id'  => 2,
                    'foo' => 'bar',
                ],
                'file2_data' => [
                    'id'  => 3,
                    'foo' => 'bar',
                ],
            ],
            [
                'file'      => [3, 4],
                'file2'     => [1, ''],
                'file_data' => [
                    3 => [
                        'id'  => 3,
                        'foo' => 'bar',
                    ],
                    4 => [
                        'id'  => 4,
                        'foo' => 'bar',
                    ],
                ],
                'file2_data' => [
                    1 => [
                        'id'  => 1,
                        'foo' => 'bar',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $collection);
    }

    public function test_it_can_fill_a_collection_with_multiple_fields_passed_as_array()
    {
        $tanker = new FooCollector();
        $collection = [
            [
                'file'  => 2,
                'file2' => 3,
            ],
            [
                'file'  => [3, 4],
                'file2' => [1, ''],
            ],
        ];

        $tanker->collection($collection)->fields(['file', 'file2'])->fill();

        $expected = [
            [
                'file'      => 2,
                'file2'     => 3,
                'file_data' => [
                    'id'  => 2,
                    'foo' => 'bar',
                ],
                'file2_data' => [
                    'id'  => 3,
                    'foo' => 'bar',
                ],
            ],
            [
                'file'      => [3, 4],
                'file2'     => [1, ''],
                'file_data' => [
                    3 => [
                        'id'  => 3,
                        'foo' => 'bar',
                    ],
                    4 => [
                        'id'  => 4,
                        'foo' => 'bar',
                    ],
                ],
                'file2_data' => [
                    1 => [
                        'id'  => 1,
                        'foo' => 'bar',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $collection);
    }

    public function test_it_can_fill_a_single_item()
    {
        $tanker = new FooCollector();
        $item = [
            'file' => 2,
        ];

        $tanker->item($item)->fields('file')->fill();

        $expected = [
            'file'      => 2,
            'file_data' => [
                'id'  => 2,
                'foo' => 'bar',
            ],
        ];

        $this->assertEquals($expected, $item);
    }

    public function test_it_can_fill_a_single_item_and_a_collection_at_the_same_time()
    {
        $tanker = new FooCollector();

        $item = [
            'file' => 2,
        ];

        $collection = [
            [
                'file' => 2,
            ],
            [
                'file' => 1,
            ],
        ];

        $tanker->item($item)->fields('file');
        $tanker->collection($collection)->fields('file')->fill();

        $expected1 = [
            'file'      => 2,
            'file_data' => [
                'id'  => 2,
                'foo' => 'bar',
            ],
        ];

        $expected2 = [
            [
                'file'      => 2,
                'file_data' => [
                    'id'  => 2,
                    'foo' => 'bar',
                ],
            ],
            [
                'file'      => 1,
                'file_data' => [
                    'id'  => 1,
                    'foo' => 'bar',
                ],
            ],
        ];

        $this->assertEquals($expected1, $item);
        $this->assertEquals($expected2, $collection);
    }

    public function test_it_can_fill_a_collection_according_to_select()
    {
        $tanker = new FooCollector();
        $collection = [
            [
                'file' => 2,
            ],
            [
                'file' => 1,
            ],
        ];
        $tanker->collection($collection)->fields('file')->select(['foo'])->fill();

        $expected = [
            [
                'file'      => 2,
                'file_data' => [
                    'foo' => 'bar',
                ],
            ],
            [
                'file'      => 1,
                'file_data' => [
                    'foo' => 'bar',
                ],
            ],
        ];

        $this->assertEquals($expected, $collection);
    }

    public function test_it_can_return_if_no_ids_are_found()
    {
        $tanker = new FooCollector();
        $collection = [
            [
                'file' => '',
            ],
            [
                'file' => [],
            ],
        ];
        $tanker->collection($collection)->fields('file')->fill();

        $expected = [
            [
                'file'      => '',
                'file_data' => [],
            ],
            [
                'file'      => [],
                'file_data' => [],
            ],
        ];

        $this->assertEquals($expected, $collection);
    }

    public function test_it_can_get_data_from_a_single_item_and_a_collection_at_the_same_time()
    {
        $tanker = new FooCollector();
        
        $item = [
            'id' => 3,
            'file' => 2,
        ];

        $collection = [
            [
                'id' => 4,
                'file2' => 1,
            ]
        ];

        $tanker->item($item)->fields('file');
        $tanker->collection($collection)->fields('file2');
        $data = $tanker->get();

        $expected = [
            2 => [
                'id'  => 2,
                'foo' => 'bar',
            ],
            1 => [
                'id'  => 1,
                'foo' => 'bar',
            ],
        ];

        $this->assertEquals($expected, $data);
    }
}