<?php
/**
 * Created by PhpStorm.
 * User: yoosuf
 * Date: 08/02/2016
 * Time: 23:53
 */

namespace App\Http\Controllers;


use App\Handset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HandsetController extends ApiController
{
    private $handset;

    /**
     * HandsetController constructor.
     * @param Handset $handset
     */
    public function __construct(Handset $handset)
    {
        $this->handset = $handset;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerHandset(Request $request)
    {
        $this->validate($request, Handset::$rules);

        if(empty($request->device_id)) {
            $data = $this->handset->create($request->all());
        } else {
            $data = $this->handset->where('device_id', $request->device_id)->first();
            $data->update($request->all());

        }
        return $this->respondWithSuccess($data);
    }

}