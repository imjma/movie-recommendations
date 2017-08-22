<?php

use App\Services\MovieFilterService;

class MovieFilterServiceTest extends TestCase
{
    private $movieFilter;

    public function setUp()
    {
        parent::setUp();

        $this->movieFilter = new MovieFilterService();
    }

    /**
     * @dataProvider genreProvider
     */
    public function testByGenre($movies, $genre, $expected)
    {
        $this->assertEquals($expected, $this->movieFilter->byGenre($movies, $genre));
    }

    public function genreProvider()
    {
        $movies = $this->data();
        return [
            [$movies, 'Comedy', [$movies[0], $movies[1], $movies[3]]],
            [$movies, 'comedy', [$movies[0], $movies[1], $movies[3]]],
            [$movies, 'Drama', [$movies[0], $movies[2]]],
            [$movies, 'Animation', [$movies[2], $movies[3]]],
        ];
    }

    /**
     * @dataProvider timeProvider
     */
    public function testByTime($movies, $time, $expected)
    {
        $this->assertEquals($expected, $this->movieFilter->byTime($movies, $time));
    }

    public function timeProvider()
    {
        $movies = $this->data();
        return [
            [$movies, '18:45', [$movies[1], $movies[2]]],
            [$movies, '19:00', [$movies[1], $movies[2], $movies[3]]],
            [$movies, '22:00', []],
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