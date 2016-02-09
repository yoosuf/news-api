<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Dingo\Api\Routing\Helpers;


class ApiController extends Controller {

    use Helpers;
    
    
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
