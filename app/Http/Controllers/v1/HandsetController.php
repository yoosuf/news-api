<?php

namespace App\Http\Controllers\v1;


use App\Models\Handset;
use App\Transformers\v1\CategoryTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Taxonomy;


class HandsetController extends ApiController
{
    private $handset;
    protected $taxonomy;


    /**
     * HandsetController constructor.
     * @param Taxonomy $taxonomy
     * @param Handset $handset
     */
    function __construct(Taxonomy $taxonomy, Handset $handset)
    {
        $this->taxonomy = $taxonomy;
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

            return ["data" => $data];
        }

        $handset->update($request->all());

        $data = [
            'user_id' => (integer) $handset->user_id,
            'device_type' => $handset->device_type,
            'device_id' => $handset->device_id,
            'push_token ' => (string) $handset->push_token,
            'access_token ' => $handset->access_token,
        ];

        return ["data" => $data];

    }


    /**
     * @param CategoryTransformer $categoryTransformer
     * @return mixed
     */
    public function getAppSpecificSettings(CategoryTransformer $categoryTransformer, $device_id = null, $device_type = null)
    {
        $handset =  $this->handset
            ->where('device_id', $device_id)
            ->where('device_type', $device_type)
            ->first();

        if(count($handset) > 0) {

            // get the categories which is been selected and show a true and false

        }

        // else show all categories with false

        $categories = $this->taxonomy->category()->get();
        return $this->collection($categories, $categoryTransformer);

    }


    public function postAppSpecificSettings(Request $request, $device_id = null, $device_type = null) {

        $handset =  $this->handset
            ->where('device_id', $device_id)
            ->where('device_type', $device_type)
            ->first();
        if(count($handset) > 0) {

            // update

        }


        // save
    }




}