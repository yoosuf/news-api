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

    /**
     * @param $id
     * @param Manager $fractal
     * @param PostTransformer $postTransformer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, Manager $fractal, PostTransformer $postTransformer)
    {
        $post = $this->post->find($id);
        if(empty($post))
            return $this->respondNotFound();

        $item = new Item($post, $postTransformer);
        $data = $fractal->createData($item)->toArray();

        return $this->respondWithSuccess($data);

    }


    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description'  => 'required',
            'category' => 'required',
        ];

        $this->validate($request, $rules);

        $data = [
            'post_title' => $request->title,
            'post_content' => $request->description,
            'main_category' => $request->category,
        ];

        $this->post->create($data);

        return $this->respondWithSuccess("The post has been added");

    }

}