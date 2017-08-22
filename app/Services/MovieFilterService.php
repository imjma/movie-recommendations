<?php

namespace App\Services;

use App\Helpers\DateTimeHelper;
use Carbon\Carbon;

class MovieFilterService extends Service
{
    /**
     * Gap between movie showing time and input time
     *
     * @var mixed
     */
    private $gapOfMins;

    /**
     * MovieFilterService constructor.
     */
    public function __construct()
    {
        $this->gapOfMins = env('GAP_OF_MINS', 30);
    }

    /**
     * run filter by params, and sort with rating if more than one
     *
     * @param array $movies
     * @param       $params
     * @return array
     */
    public function recommend(array $movies, $params)
    {
        foreach ($params as $key => $param) {
            $method = 'by' . ucwords($key);
            if (!is_null($param) && method_exists($this, $method)) {
                $movies = $this->$method($movies, $param);
            }
        }

        // if more than one recommendation, order by rating
        if (count($movies) > 1) {
            $movies = $this->sortByRating($movies);
        }

        return $movies;
    }

    /**
     * filter by genre
     *
     * @param $movies
     * @param $genre
     * @return array
     */
    public function byGenre($movies, $genre)
    {
        return array_values(array_filter($movies, function ($movie) use ($genre) {
            return in_array(strtolower($genre), array_map('strtolower', $movie['genres']));
        }));
    }

    /**
     * filter by time
     *
     * @param $movies
     * @param $time
     * @return array
     */
    public function byTime($movies, $time)
    {
        return array_values(array_filter($movies, function ($movie) use ($time) {
            return !empty(DateTimeHelper::getTimesAheadOfMins($movie['showings'], DateTimeHelper::appendSecondAndTZ($time), $this->gapOfMins));
        }));
    }

    /**
     * sort movies by rating
     *
     * @param $movies
     * @return mixed
     */
    public function sortByRating($movies)
    {
        // only sort with more than one movies
        if (count($movies) > 1) {
            usort($movies, function ($m1, $m2) {
                return $m1['rating'] < $m2['rating'];
            });
        }

        return $movies;
    }
}