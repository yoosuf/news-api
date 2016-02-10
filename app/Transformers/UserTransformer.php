<?php
/**
 * Created by PhpStorm.
 * User: yoosuf
 * Date: 10/02/2016
 * Time: 17:01
 */

namespace App\Transformers;


use Corcel\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'name' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ]
        ];
    }


}