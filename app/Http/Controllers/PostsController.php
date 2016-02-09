<?php
/**
 * Created by PhpStorm.
 * User: yoosuf
 * Date: 08/02/2016
 * Time: 18:48
 */

namespace App\Http\Controllers;

use App\Transformers\PostTransformer;
use Corcel\Post;
use Dingo\Api\Exception\StoreResourceFailedException;
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
    public function index(PostTransformer $postTransformer)
    {
//        stats_views
        $posts = $this->post->get();
        return $this->collection($posts, $postTransformer);
    }

    /**
     * @param $id
     * @param Manager $fractal
     * @param PostTransformer $postTransformer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, PostTransformer $postTransformer)
    {
        $post = $this->post->find($id);
        if(empty($post))
            return $this->response->errorNotFound();

        return $this->item($post, $postTransformer);
    }


    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description'  => 'required',
            'category' => 'required',
        ];

        $validator = app('validator')->make($request->all(), $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not add the news.', $validator->errors());
        }

        $data = [
            'post_title' => $request->title,
            'post_content' => $request->description,
            'main_category' => $request->category,
        ];

        $this->post->create($data);

        return $this->response->created();

    }

}