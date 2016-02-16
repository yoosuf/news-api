<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
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
        return $this->respond($data);
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
