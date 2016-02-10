<?php
/**
 * Created by PhpStorm.
 * User: yoosuf
 * Date: 10/02/2016
 * Time: 17:17
 */

namespace App\Http\Controllers\v1;


use App\Http\Controllers\ApiController;
use App\Transformers\AuthorTransformer;
use Corcel\User;

class AuthorsController extends  ApiController
{


    public function getUsers(AuthorTransformer $authorTransformer) {

        $users = User::paginate(10);

        return $this->response->paginator($users, $authorTransformer);
    }



}