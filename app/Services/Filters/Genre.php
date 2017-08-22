<?php

namespace App\Services\Filters;

/**
 * Class Genre
 * @package App\Services\Filters
 */
class Genre implements Filter
{
    /**
     * Filter movies by genre
     *
     * @param $movies
     * @param $genre
     * @return array
     */
    public function filter($movies, $genre)
    {
        return array_values(array_filter($movies, function ($movie) use ($genre) {
            return in_array(strtolower($genre), array_map('strtolower', $movie['genres']));
        }));
    }
}