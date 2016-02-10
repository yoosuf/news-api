<?php

namespace App\Transformers;

use Corcel\Post;
use League\Fractal\TransformerAbstract;

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
            'id' => (int)$post->ID,
            'title' => $post->post_title,
            'description' => $post->post_content,
            'excerpt' => $post->post_excerpt,
            'thumbnail' => $post->image,
            'links' => [
                'rel' => 'self',
                'uri' => $post->guid,
            ],
            'comment_count' => $post->comment_count,
            'created_at' => $post->post_date,
            'updated_at' => $post->post_modified,
        ];
    }


    /**
     * @param Post $post
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUsers(Post $post)
    {
        $users = $post->users;

        return $this->collection($users, new UserTransformer);
    }


}