<?php

namespace App\Http\Transformers;

use App\Facades\DateTimeHelper;
use League\Fractal\TransformerAbstract;

/**
 * Class Movie Transformer
 * @package App\Http\Transformers
 */
class Movie extends TransformerAbstract
{
    /**
     * @var null|int
     */
    private $time;

    /**
     * Gap between showing time and input time
     *
     * @var mixed
     */
    private $gapOfMins;

    /**
     * Movie constructor.
     * @param null $time
     */
    public function __construct($time = null)
    {
        $this->time = $time;
        $this->gapOfMins = env('GAP_OF_MINS', 30);
    }

    /**
     * @param $movie
     * @return array
     */
    public function transform($movie)
    {
        $showing = DateTimeHelper::parseMovieShowingTime($movie['showings'][0]);
        if (!is_null($this->time)) {
            $showings = DateTimeHelper::getTimesAheadOfMins($movie['showings'], DateTimeHelper::appendSecondAndTZ($this->time), $this->gapOfMins);
            if (!empty($showings)) {
                $showing = DateTimeHelper::parseMovieShowingTime($showings[0]);
            }
        }

        return [
            $movie['name'] . ', showing at ' . $showing,
        ];
    }
}