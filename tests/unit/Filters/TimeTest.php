<?php

use App\Services\Filters\Time;

class TimeTest extends TestCase
{
    /**
     * @dataProvider filterProvider
     */
    public function testFilter($filter, $movies, $time, $expected)
    {
        $this->assertEquals($expected, $filter->filter($movies, $time));
    }

    public function filterProvider()
    {
        $filter = new Time();
        $movies = $this->data();
        return [
            [$filter, $movies, '18:45', [$movies[1], $movies[2]]],
            [$filter, $movies, '19:00', [$movies[1], $movies[2], $movies[3]]],
            [$filter, $movies, '22:00', []],
        ];
    }

    private function data()
    {
        return [
            0 => [
                'name'=> 'Test 1',
                'rating' => 98,
                'genres' => [
                    'Comedy', 'Drama'
                ],
                'showings' => [
                    '20:00:00+11:00',
                    '10:00:00+11:00',
                ]
            ],
            1 => [
                'name'=> 'Test 2',
                'rating' => 50,
                'genres' => [
                    'Comedy'
                ],
                'showings' => [
                    '20:30:00+11:00',
                    '19:00:00+11:00',
                ]
            ],
            2 => [
                'name'=> 'Test 3',
                'rating' => 80,
                'genres' => [
                    'Drama', 'Animation'
                ],
                'showings' => [
                    '19:00:00+11:00',
                    '20:00:00+11:00',
                ]
            ],
            3 => [
                'name'=> 'Test 4',
                'rating' => 90,
                'genres' => [
                    'comedy', 'Animation'
                ],
                'showings' => [
                    '19:30:00+11:00',
                    '20:00:00+11:00',
                ]
            ],
        ];
    }
}