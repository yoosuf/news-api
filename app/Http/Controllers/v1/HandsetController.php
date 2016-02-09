<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;

use App\Handset;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;


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


        $validator = app('validator')->make($request->all(), $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not add the device.', $validator->errors());
        }


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

        return ["data" => $data];

    }






}