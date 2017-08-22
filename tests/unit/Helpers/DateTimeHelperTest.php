<?php

use App\Helpers\DateTimeHelper;
use Carbon\Carbon;

class DateTimeHelperTest extends TestCase
{
    public function testParseTimeWithTZ()
    {
        $dt = DateTimeHelper::parseTimeWithTZ('19:15:00+11:00');
        $this->assertInstanceOf(Carbon::class, $dt);
    }

    public function testParseMovieShowingTime()
    {
        $res = DateTimeHelper::parseMovieShowingTime('19:15:00+11:00');
        $this->assertEquals('7:15pm', $res);

        $res = DateTimeHelper::parseMovieShowingTime('19:00:00+11:00');
        $this->assertEquals('7pm', $res);
    }

    public function testAppendSecondAndTZ()
    {
        $res = DateTimeHelper::appendSecondAndTZ('19:15');
        $this->assertEquals('19:15:00+' . env('MOVIE_TIMEZONE', '11:00'), $res);
    }

    /**
     * @dataProvider getTimeAheadOfMinsProvider
     */
    public function testGetTimeAheadOfMins($times, $inputTime, $gap, $expected)
    {
        $res = DateTimeHelper::getTimesAheadOfMins($times, $inputTime, $gap);
        $this->assertEquals($expected, count($res));
    }

    public function getTimeAheadOfMinsProvider()
    {
        $times = ['19:00:00+11:00', '20:00:00+11:00', '22:00:00+11:00'];
        return [
            [$times, '18:45:00+11:00', 30, 1],
            [$times, '18:45:00+11:00', 130, 2],
            [$times, '21:45:00+11:00', 30, 1],
        ];
    }
}