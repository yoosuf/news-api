<?php

namespace App\Http\Controllers\v1;
use App\Http\Controllers\ApiController;

class DocsController extends ApiController
{

    public function index() {


        $data = [
            'register_handset' => '/handset/register',
            'categories' => '/categories',
            'categories_by_id' => '/categories/{id}',
            'popular_posts' => '/posts/popular',
            'posts_by_id' => '/posts/{id}',
        ];


	return $this->response->array($data);
    }

}