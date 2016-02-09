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
        $rules = [
            'device_type' => 'required',
            'device_id' => 'required',
        ];

        $this->validate($request, $rules);

        $handset = $this->handset->where('device_id', $request->device_id)->first();

        if(empty($handset)) {
            $handset = $request->all();
            $data = $this->handset->create($handset);
            return $this->respondWithSuccess($data);
        }

        $handset->update($request->all());

        $data = [
            'device_type' => $handset->device_type,
            'device_id' => $handset->device_id,
            'push_token ' => (string) $handset->push_token,
            'access_token ' => $handset->access_token,
        ];

        return $this->respondWithSuccess($data);

    }






}