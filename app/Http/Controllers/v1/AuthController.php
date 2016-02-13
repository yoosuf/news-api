<?php

namespace App\Http\Controllers\v1;

use App\Models\AppUser;
use App\Http\Controllers\ApiController;
use App\Models\SocialProvider;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;

class AuthController extends ApiController
{

    private $appUser;

    private $socialProvider;


    /**
     * AuthController constructor.
     * @param AppUser $appUser
     * @param SocialProvider $socialProvider
     */
    public function __construct(AppUser $appUser, SocialProvider $socialProvider)
    {
        $this->appUser = $appUser;
        $this->socialProvider = $socialProvider;
    }

    public function createAppUser(Request $request)
    {

        $rules = [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'provider_type' => 'required',
            'provider_key' => 'required',
            'avatar_url'  => 'required',
        ];

        $validator = app('validator')->make($request->all(), $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not add the user.', $validator->errors());
        }

        $user = $this->appUser->where('email', $request->email)->first();

        if(empty($user)) {
            $user = $request->all();
            $user = $this->appUser->create($user);

        }

        $socialData = [
            'app_user_id' => $user->id,
            'provider_type' => $request->provider_type,
            'provider_key' => $request->provider_key,
            'avatar_url' => $request->avatar_url,

        ];

        $profile = $this->socialProvider->where('app_user_id', $user->id)->where('provider_type', $request->provider_type)->first();

        if (empty($profile)) {
            $profile = $this->socialProvider->create($socialData);

            $data = [
                'email' => $user->email,
                'name' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                ],
                'provider_type' => $profile->provider_type,
                'provider_key' => $profile->provider_key,
                'avatar_url ' =>  $profile->avatar_url,
            ];

            return ["data" => $data];
        }

        $this->socialProvider->update($socialData);

        $data = [
            'email' => $user->email,
            'name' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ],
            'provider_type' => $profile->provider_type,
            'provider_key' => $profile->provider_key,
            'avatar_url ' =>  $profile->avatar_url,
        ];

        return ["data" => $data];



    }




}