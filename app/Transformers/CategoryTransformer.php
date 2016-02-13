<?php

namespace App\Transformers;

use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Taxonomy;

class CategoryTransformer extends TransformerAbstract
{


    protected $availableIncludes = [
        'posts'
    ];


    /**
     * @param Taxonomy $taxonomy
     * @return array
     */
    public function transform(Taxonomy $taxonomy)
    {
        return [
            'id'           => $taxonomy->term_id,
            'name'         => $taxonomy->term->name,
            'description'  => $taxonomy->description,
            'count'         => $taxonomy->count
        ];
    }


    /**
     * @param Taxonomy $taxonomy
     * @return Collection
     */
    public function includePosts(Taxonomy $taxonomy)
    {
        $posts = $taxonomy->posts;

        return $this->collection($posts, new PostTransformer);
    }


}