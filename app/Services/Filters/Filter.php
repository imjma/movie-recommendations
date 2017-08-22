<?php

namespace App\Services\Filters;

interface Filter
{
    public function filter($movies, $keyword);
}