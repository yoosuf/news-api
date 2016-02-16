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

                'description' => "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://api.liveat8.lk/css/app.css?update=today\"><div itemscope itemtype=\"http://schema.org/Periodical\"><img src='".$post->image ."'/>"."<div class=\"post\"><h1  itemprop=\"name\">".$post->post_title."</h1><ul class=\"post-meta\"><li><time datetime=\"2010-07-03\" itemprop=\"datePublished\">".$post->post_date."</time></li></ul><div itemprop=\"description\">".$post->post_content . "</div></div><footer>
© ".date("Y")." ඊ.ඒ.පී. ගුවන් විදුලි සමාගම . සියලුම හිමිකම් ඇවිරිණි.</footer></div>",
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