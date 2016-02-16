<?php

namespace App\Transformers\v1;


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