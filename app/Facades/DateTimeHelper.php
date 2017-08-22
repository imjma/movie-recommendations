<?php

namespace App\Facades;

class DateTimeHelper extends Facades
{
    public static function getFacadeAccessor()
    {
        return \App\Helpers\DateTimeHelper::class;
    }
}