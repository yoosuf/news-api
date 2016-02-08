<?php

namespace App\Http\Controllers;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
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
    public function index(Manager $fractal, CategoryTransformer $categoryTransformer)
    {
        $categories = $this->taxonomy->category()->get();
        $collection = new Collection($categories, $categoryTransformer);
        $data = $fractal->createData($collection)->toArray();
        return $this->respond($data);
    }


    /**
     * @param $id
     * @param Manager $fractal
     * @param CategoryTransformer $categoryTransformer
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function show($id, Manager $fractal, CategoryTransformer $categoryTransformer)
    {
        $category = $this->taxonomy->category()->where('term_id', $id)->first();
        if(empty($category))
            return $this->respondNotFound();

        $item = new Item($category, $categoryTransformer);
        $data = $fractal->createData($item)->toArray();

        return $this->respondWithSuccess($data);
    }
}