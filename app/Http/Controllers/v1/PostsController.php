<?php
namespace App\Http\Controllers\v1;

use App\Transformers\v1\PostTransformer;
use Corcel\Options;
use Corcel\Post;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Taxonomy;

class PostsController extends ApiController
{
    protected $post;

    protected $taxonomy;

    /**
     * PostsController constructor.
     * @param Post $post
     * @param Taxonomy $taxonomy
     */
    public function __construct(Post $post, Taxonomy $taxonomy)
    {

        $this->post = $post;
        $this->taxonomy = $taxonomy;

    }

    public function getToDaysPosts(PostTransformer $postTransformer) {

        $posts = $this->post->type('post')
            ->join('postmeta', 'posts.id', '=', 'postmeta.post_id')
            ->where('post_type', 'post')
            ->where('post_status', 'publish')
            ->where('meta_key', 'post_views_count')
            ->where('post_date', '>', Carbon::today())
            ->orderBy('post_date', 'DESC')
            ->paginate(10);
        return $this->response->paginator($posts, $postTransformer);

    }


    /**
     * @param PostTransformer $postTransformer
     * @return \Dingo\Api\Http\Response
     */
    public function getTopStories(PostTransformer $postTransformer) {
        
        $tags = $this->taxonomy->whereTaxonomy('post_tag')->whereTermId(56)->first();

        $posts = $tags->posts()
            ->where('post_status', 'publish')
            ->orderBy('post_date', 'DESC')
            ->paginate(10);

        return $this->paginator( $posts, $postTransformer);
    }


    /**
     * @param PostTransformer $postTransformer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPopularPosts(PostTransformer $postTransformer)
    {

        $posts = $this->post->type('post')
            ->join('postmeta', 'posts.id', '=', 'postmeta.post_id')
            ->where('meta_key', 'post_views_count')
            ->orderBy('meta_value', 'DESC')
            ->paginate(10);


        return $this->response->paginator($posts, $postTransformer);
    }


    /**
     * @param $id
     * @param PostTransformer $postTransformer
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostById($id, PostTransformer $postTransformer)
    {
        $post = $this->post->find($id);

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
            'description' => 'required',
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


    /**
     * @param $post
     */
    private function updatePostShowCount($post)
    {
        $post->meta->post_views_count = ++$post->meta->post_views_count;
        $post->save();
    }

}