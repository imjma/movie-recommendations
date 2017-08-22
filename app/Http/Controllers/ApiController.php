<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    /**
     * Return success response
     *
     * @param     $data
     * @param int $code
     * * @param string $format
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data, $code = 200, $format = 'json')
    {
        return $this->output($data, $code, $format);
    }

    /**
     * Return error response
     *
     * @param $message
     * @param $code
     * * @param string $format
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $code = 400, $format = 'json')
    {
        return $this->output(['message' => $message], $code, $format);
    }

    /**
     * Return empty data or message
     *
     * @param null   $message
     * @param int    $code
     * @param string $format
     * @return \Illuminate\Http\JsonResponse
     */
    public function empty($message = null, $code = 200, $format = 'json')
    {
        return $this->output(is_null($message) ? [] : ['message' => $message], $code, $format);
    }

    /**
     * @param        $output
     * @param        $code
     * @param string $format
     * @return \Illuminate\Http\JsonResponse
     */
    private function output($output, $code, $format)
    {
        switch ($format) {
            case 'json':
            default:
                return response()->json($output, $code);
        }
    }
}
