<?php

namespace App\Transformers\v1;

use Corcel\Post;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

use App\Utils\ContentCreator;

class PostTransformer extends TransformerAbstract
{

    protected $contentCreator;

    protected $defaultIncludes = [
    ];

    /**
     * PostTransformer constructor.
     * @param ContentCreator $contentCreator
     */
    public function __construct(ContentCreator $contentCreator)
    {
        $this->contentCreator = $contentCreator;
    }

    /**
     * @param Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => (int)$post->ID,
            'title' => $post->post_title,
            'description' => $post->post_content,
            'thumbnail' => $post->image,
            'article_html' =>  $this->contentCreator->enhancedContent($post->image, $post->post_title, $post->post_date, $post->post_content),
            'links' => [
                'rel' => 'self',
                'uri' => $post->guid,
            ],
            'post_views' => (int)$post->meta->post_views_count,
            'comment_count' => $post->comment_count,
            'created_at' => $post->post_date,
            'updated_at' => $post->post_modified,
        ];
    }


    /**
     * @param Post $post
     * @return \League\Fractal\Resource\Collection
     */
    public function includeCategories(Post $post)
    {
        $taxonomies = $post->taxonomies;

        return $this->collection($taxonomies, new CategoryTransformer);
    }


    /**
     * @param Post $post
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTags(Post $post)
    {
        $taxonomies = $post->taxonomies->term;

        return $this->collection($taxonomies, new CategoryTransformer);
    }


}