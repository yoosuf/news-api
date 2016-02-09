<?php
/**
 * Created by PhpStorm.
 * User: yoosuf
 * Date: 09/02/2016
 * Time: 06:23
 */

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AppMiddleware
{

    protected $headers = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'POST, GET',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization, Accept, X-Requested-With, Origin',
        'Access-Control-Allow-Credentials' => 'true',
        "Cache-Control" => "max-age=0, private, must-revalidate",
    ];

    /**
     * Request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;


    /**
     *
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $this->setCorsHeaders($response);


    }






    /**
     * @param $response
     * @return mixed
     */
    public function setCorsHeaders($response)
    {
        foreach ($this->headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}