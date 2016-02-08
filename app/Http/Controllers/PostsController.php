<?php
/**
 * Created by PhpStorm.
 * User: yoosuf
 * Date: 08/02/2016
 * Time: 18:48
 */

namespace App\Http\Controllers;


use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;
use App\Transformers\PostTransformer;
use Category;
use Corcel\Post;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class PostsController extends ApiController
{


    protected $post;

    public function __construct(Post $post)
    {

        $this->post = $post;

    }

    /**
     * @param Manager $fractal
     * @param PostTransformer $postTransformer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Manager $fractal, PostTransformer $postTransformer)
    {

//        stats_views
        $posts = $this->post->get();
        $collection = new Collection($posts, $postTransformer);
        $data = $fractal->createData($collection)->toArray();
        return $this->respond($data);
    }

    public function show($id, Manager $fractal, PostTransformer $postTransformer)
    {


        $post = $this->post->find($id);
        if(empty($post))
            return $this->respondNotFound();

        $item = new Item($post, $postTransformer);
        $data = $fractal->createData($item)->toArray();

        return $this->respondWithSuccess($data);

    }

}