<?php

namespace App\Http\Controllers;

use App\Handset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        return $this->respond($data);
    }

}