<?php


namespace App\Http\Requests;

use Dingo\Api\Contract\Http\Validator;
use Illuminate\Http\Request;

class Headers implements Validator
{
    protected $headers = [];

    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function validate(Request $request)
    {
        foreach ($this->headers as $header) {
            if (!$request->headers->has($header)) {
                return false;
            }
        }

        return true;
    }
}