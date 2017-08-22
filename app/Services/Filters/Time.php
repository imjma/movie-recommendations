<?php

namespace App\Services\Filters;

use App\Facades\DateTimeHelper;

/**
 * Class Time
 * @package App\Services\Filters
 */
class Time implements Filter
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
     * Filter movies by time
     *
     * @param $movies
     * @param $time
     * @return array
     */
    public function filter($movies, $time)
    {
        return array_values(array_filter($movies, function ($movie) use ($time) {
            return !empty(DateTimeHelper::getTimesAheadOfMins($movie['showings'], DateTimeHelper::appendSecondAndTZ($time), $this->gapOfMins));
        }));
    }
}