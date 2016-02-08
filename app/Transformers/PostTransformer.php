<?php

namespace App\Transformers;
use Corcel\Post;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Category;

class PostTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [

    ];


    /**
     * @param Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id'           => (int) $post->ID,
            'title' => $post->post_title,
            'content'  => $post->post_content,
            'excerpt' =>$post->post_excerpt,
            'thumbnail' => $post->image,
            'links' => [
                'rel' => 'self',
                'uri' => $post->guid,
            ],
            "author" => [
                'author_id' => $post->author_id,
            ],
            'comment_count' => $post->comment_count,
            'created_at'    => $post->post_date,
            'updated_at'    => $post->post_modified,
        ];
    }


}