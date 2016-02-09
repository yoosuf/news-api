<?php

namespace App\Http\Controllers;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use Taxonomy;

class CategoriesController extends ApiController
{


    private $fractal;
    private $request;
    protected $taxonomy;


    /**
     * CategoriesController constructor.
     * @param Manager $fractal
     * @param Taxonomy $taxonomy
     * @param Request $request
     */
    function __construct(Manager $fractal, Taxonomy $taxonomy, Request $request)
    {
        $this->fractal = $fractal;
        $this->fractal->parseIncludes($this->getIncludes());
        $this->taxonomy = $taxonomy;
        $this->request = $request;
    }


    /**
     * @param Manager $fractal
     * @param CategoryTransformer $categoryTransformer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CategoryTransformer $categoryTransformer)
    {
        $categories = $this->taxonomy->category()->get();

        return $this->collection($categories, $categoryTransformer);

    }


    /**
     * @param $id
     * @param Manager $fractal
     * @param CategoryTransformer $categoryTransformer
     */
    public function show($id,  CategoryTransformer $categoryTransformer)
    {
        $category = $this->taxonomy->category()->where('term_id', $id)->first();
        if(empty($category))
            return $this->response->errorNotFound();

        return $this->item($category, $categoryTransformer);

    }
}