<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Transformers\PostTransformer;
use Corcel\Post;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Resource\Collection;

class PostsController extends ApiController
{
    protected $post;

    /**
     * PostsController constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {

        $this->post = $post;

    }

    /**
     * @param PostTransformer $postTransformer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPopular(PostTransformer $postTransformer, Request $request)
    {

//        query_posts('meta_key=post_views_count&orderby=meta_value_num&order=DESC');
//        if (have_posts()) : while (have_posts()) : the_post();
//        endwhile; endif;
//        wp_reset_query();

        $posts = $this->post->type('post')->published()->hasMeta('post_views_count')->orderBy('post_date', 'DESC')->paginate(10);

        return $this->response->paginator( $posts , $postTransformer);




    }



    /**
     * @param $id
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


    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
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