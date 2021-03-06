<?php

namespace App\Http\Controllers\v1;


use App\Transformers\v1\CategoryTransformer;
use App\Transformers\v1\PostTransformer;
use Corcel\Post;
use Taxonomy;

class CategoriesController extends ApiController
{

    protected $taxonomy;
    protected $post;


    /**
     * CategoriesController constructor.
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
    public function getAllCategories(CategoryTransformer $categoryTransformer)
    {
        $categories = $this->taxonomy->category()->get();
        return $this->collection($categories, $categoryTransformer);
    }


    /**
     * @param $id
     * @param CategoryTransformer $categoryTransformer
     */
    public function getCategoryById($id, CategoryTransformer $categoryTransformer)
    {
        $category = $this->taxonomy->category()->with('posts')->whereTermId( $id)->first();
        if(empty($category))
            return $this->response->errorNotFound();

        return $this->item($category, $categoryTransformer);
    }


    /**
     * @param $id
     * @param PostTransformer $postTransformer
     * @return mixed
     */
    public function getCategoryWithPosts($id, PostTransformer $postTransformer)
    {
        $category = $this->taxonomy->category()->whereTermId($id)->first();

        $posts = $category->posts()
            ->where('post_status', 'publish')
            ->orderBy('post_date', 'DESC')
            ->paginate(10);

        return $this->paginator( $posts, $postTransformer);
    }

}