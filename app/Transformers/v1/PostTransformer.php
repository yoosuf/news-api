<?php

namespace App\Transformers\v1;

use Corcel\Post;
use Illuminate\Database\Eloquent\Collection;
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
                'description' => "<h1>".$post->post_title."</h1>".$post->post_content,
                'excerpt' => $post->post_excerpt,
                'thumbnail' => $post->image,
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
    public function includeUsers(Post $post)
    {
        $users = $post->users;

        return $this->collection($users, new UserTransformer);
    }


}