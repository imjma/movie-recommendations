<?php

namespace App\Helpers;

use Carbon\Carbon;

/**
 * Class DateTimeHelper
 * @package App\Helpers
 */
class DateTimeHelper extends Helper
{
    /**
     * Convert time string to Carbon
     *
     * @param $time '19:15:00+11:00'
     * @return Carbon
     */
    public static function parseTimeWithTZ(string $time) : Carbon
    {
        return Carbon::createFromFormat('H:i:sP', $time);
    }

    /**
     * Convert time string and ready to display
     *
     * @param        $time
     * @param string $format
     * @return string
     */
    public static function parseMovieShowingTime(string $time, string $format='g:ia') : string
    {
        $dt = self::parseTimeWithTZ($time);
        if ($dt->format('i') == '00') {
            $format = 'ga';
        }
        return $dt->format($format);
    }

    /**
     * Append second and timezone
     *
     * @param string $time
     * @return string
     */
    public static function appendSecondAndTZ(string $time) : string
    {
        return $time . ':00+' . env('MOVIE_TIMEZONE', '11:00');
    }

    /**
     * Find the time ahead of input time with given gap of mins
     *
     * @param array  $times
     * @param string $inputTime
     * @param int    $gapOfMins
     * @return array
     */
    public static function getTimesAheadOfMins(array $times, string $inputTime, int $gapOfMins) : array
    {
        $diffTime = self::parseTimeWithTZ($inputTime);
        return array_values(array_filter($times, function ($time) use ($diffTime, $gapOfMins) {
            return $diffTime->diffInMinutes(self::parseTimeWithTZ($time)) <= $gapOfMins;
        }));
    }
}