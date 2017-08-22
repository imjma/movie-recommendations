<?php

namespace App\Services;

/**
 * Class DataSourceService
 * @package App\Services
 */
class DataSourceService extends Service
{
    /**
     * Data Source URL
     *
     * @var string
     */
    private $dataSource;

    /**
     * DataSourceService constructor.
     */
    public function __construct()
    {
        $this->dataSource = env('DATA_SOURCE');
    }

    /**
     * Get data source and decode it to array
     *
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        $res = $this->request('GET', $this->dataSource);
        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents(), true);
        } else {
            throw new \Exception('Please check the data source url is correct', $res->getStatusCode());
        }
    }

    /**
     * Guzzle request method
     *
     * @param $method
     * @param $url
     * @return mixed
     */
    private function request($method, $url)
    {
        return app('GuzzleClient')->request($method, $url);
    }
}