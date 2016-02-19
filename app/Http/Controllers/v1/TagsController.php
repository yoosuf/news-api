<?php

namespace App\Http\Controllers\v1;


use App\Transformers\v1\CategoryTransformer;
use App\Transformers\v1\PostTransformer;
use Corcel\Post;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use Taxonomy;

class TagsController extends ApiController
{

    protected $taxonomy;
    protected $post;


    /**
     * TagsController constructor.
     * @param Taxonomy $taxonomy
     * @param Post $post
     */
    function __construct(Taxonomy $taxonomy, Post $post)
    {
        $this->taxonomy = $taxonomy;
        $this->post = $post;
    }


    /**
     * @param CategoryTransformer $categoryTransformer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllTags(CategoryTransformer $categoryTransformer)
    {

        $tags = $this->taxonomy->whereTaxonomy('post_tag')->orderBy('count', 'DESC')->get();

        return $this->collection($tags, $categoryTransformer);
    }


    /**
     * @param $id
     * @param CategoryTransformer $categoryTransformer
     */
    public function getTagById($id, CategoryTransformer $categoryTransformer)
    {

        $tags = $this->taxonomy->whereTaxonomy('post_tag')->whereTermId( $id)->first();

        if(empty($tags))
            return $this->response->errorNotFound();

        return $this->item($tags, $categoryTransformer);
    }


    /**
     * @param $id
     * @param PostTransformer $postTransformer
     * @return mixed
     */
    public function getTagWithPosts($id, PostTransformer $postTransformer)
    {
        $tags = $this->taxonomy->whereTaxonomy('post_tag')->whereTermId( $id)->first();


        $posts = $tags->posts()
            ->where('post_status', 'publish')
            ->orderBy('post_date', 'DESC')
            ->paginate(10);


        return $this->paginator( $posts, $postTransformer);
    }

}