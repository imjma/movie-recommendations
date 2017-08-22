<?php

use App\Services\Filters\Genre;

class GenreTest extends TestCase
{
    /**
     * @dataProvider filterProvider
     */
    public function testFilter($filter, $movies, $genre, $expected)
    {
        $this->assertEquals($expected, $filter->filter($movies, $genre));
    }

    public function filterProvider()
    {
        $filter = new Genre();
        $movies = $this->data();
        return [
            [$filter, $movies, 'Comedy', [$movies[0], $movies[1], $movies[3]]],
            [$filter, $movies, 'comedy', [$movies[0], $movies[1], $movies[3]]],
            [$filter, $movies, 'Drama', [$movies[0], $movies[2]]],
            [$filter, $movies, 'Animation', [$movies[2], $movies[3]]],
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