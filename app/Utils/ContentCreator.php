<?php
/**
 * Created by PhpStorm.
 * User: yoosuf
 * Date: 16/02/2016
 * Time: 22:54
 */

namespace App\Utils;

use Carbon\Carbon;

class ContentCreator
{


    public function enhancedContent($post_image, $post_title, $post_created_at, $post_content) {

        $data  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://api.liveat8.lk/css/app.css?update=random_string\">";
        $data .= "<article class='post'>";
        $data .= "<figure class='cover-image'><img src='".$post_image."'></figure>";
        $data .= "<header class='post-header'>";
        $data .= "<h1 class='post-title'>".$post_title."</h1>";
        $data .= "<time class='post-datetime'>".$post_created_at."</time>";
        $data .= "</header>";
        $data .= "<div class=\"post-content\">".$post_content."</div>";
        $data .= "<footer class=\"post-footer\"></footer>";
        $data .= "</article>";
        return $data;
    }


    public function cleanScrapFromContent($content) {
        return preg_replace("/<script\\b[^>]*>(.*?)<\\/script>/i", "", $content);
    }

}