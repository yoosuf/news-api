<?php

namespace App\Http\Controllers\v1;


use App\Transformers\v1\CategoryTransformer;
use App\Transformers\v1\PostTransformer;
use Corcel\Post;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use Taxonomy;

class CategoriesController extends ApiController
{


    private $fractal;
    private $request;
    protected $taxonomy;
    protected $post;


    /**
     * CategoriesController constructor.
     * @param Manager $fractal
     * @param Taxonomy $taxonomy
     * @param Post $post
     * @param Request $request
     */
    function __construct(Manager $fractal, Taxonomy $taxonomy, Post $post,  Request $request)
    {
        $this->fractal = $fractal;
        $this->fractal->parseIncludes($this->getIncludes());
        $this->taxonomy = $taxonomy;
        $this->post = $post;
        $this->request = $request;
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