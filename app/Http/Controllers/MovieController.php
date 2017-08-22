<?php

namespace App\Http\Controllers;

use App\Http\Transformers\Movie as MovieTransformer;
use App\Services\DataSourceService;
use App\Services\MovieFilterService;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

/**
 * Class MovieController
 * @package App\Http\Controllers
 */
class MovieController extends ApiController
{
    /**
     * @var DataSourceService
     */
    private $dataSourceService;

    /**
     * @var MovieFilterService
     */
    private $movieFilterService;

    /**
     * @var Manager
     */
    private $fractalManager;

    /**
     * MovieController constructor.
     * @param DataSourceService  $dataSourceService
     * @param MovieFilterService $movieFilterService
     * @param Manager            $fractalManager
     */
    public function __construct(
        DataSourceService $dataSourceService,
        MovieFilterService $movieFilterService,
        Manager $fractalManager
    ) {
        $this->dataSourceService = $dataSourceService;
        $this->movieFilterService = $movieFilterService;
        $this->fractalManager = $fractalManager;
    }

    /**
     * Movie Recommendations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommend(Request $request)
    {
        try {
            $data = $this->getMovies();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
        $filteredData = $this->movieFilterService->recommend($data, $request->only(['genre', 'time']));

        return $this->render($this->format($filteredData, $request->get('time')));
    }

    /**
     * Get all movies
     *
     * @return mixed
     */
    private function getMovies()
    {
        return $this->dataSourceService->get();
    }

    /**
     * Render data to output
     *
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function render($data)
    {
        if (count($data)) {
            return $this->success($data);
        } else {
            return $this->empty(['message' => 'no movie recommendations']);
        }
    }

    /**
     * Format movies
     *
     * @param      $movies
     * @param null $inputTime
     * @return array
     */
    private function format($movies, $inputTime = null)
    {
        $items = new Collection($movies, new MovieTransformer($inputTime));

        return $this->fractalManager->createData($items)->toArray();
    }
}