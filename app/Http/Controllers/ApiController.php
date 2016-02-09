<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Dingo\Api\Routing\Helpers;


class ApiController extends Controller {

    use Helpers;

    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }


    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }


    /**
     * Create error response
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ],
        ]);
    }



    /**
     * Create success response
     *
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithSuccess($data)
    {
        return $this->respond([
            'data' => $data,
        ]);
    }


    /**
     * Parse with including relations
     ** @return array
     */
    public function getIncludes()
    {
        return app('request')->input('include') ?: [];
    }
}
