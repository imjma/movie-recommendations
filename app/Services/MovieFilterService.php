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
            $klass = "App\\Services\\Filters\\" . ucwords($key);
            if (!is_null($param) && class_exists($klass)) {
                $movies = (new $klass())->filter($movies, $param);
            }
        }

        // if more than one recommendation, order by rating
        return $this->sortByRating($movies);
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