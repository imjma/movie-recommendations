# Movie recommendations

## Description
The movie recommendations API will return the short information of movies by the filters based on the source JSON.

Filter only supports genre and time so far.

## Installation

This API is based on [Lumen](http://lumen.laravel.com).

### Requirement

* PHP >= 7
* Composer

### Steps

1. make sure PHP 7.1 has been installed

    Mac:
    
    `brew install homebrew/php/php71`
    
    
2. run composer to install all dependencies.

    `composer create-project`
    
3. configuration `.env` , update the value

    ```
    DATA_SOURCE=https://pastebin.com/raw/cVyp3McN
    GAP_OF_MINS=30
    MOVIE_TIMEZONE=11:00
    ```

3. run lumen server

    `php -S localhost:8000 -t public`
    
### Usage

1. get full list of movies

    `http://localhost:8000/api/v1/recommend`
    
2. filter by genre, need manually url encode the params
    
    eg. `Action & Adventure` should be `Action%20%26%20Adventure`

    `http://localhost:8000/api/v1/recommend?genre=animation`
    
3. filter by time, time format must be `h:m`. eg. `19:15`, `8:30`

    `http://localhost:8000/api/v1/recommend?time=20:40`
    
4. filter by both

    `http://localhost:8000/api/v1/recommend?genre=animation&time=18:45`
    
