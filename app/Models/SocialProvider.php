<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    protected $table = 'app_social_providers';

    protected $fillable = ['app_user_id', 'provider_type', 'provider_key', 'avatar_url'];

    protected $hidden = ['updated_at', 'created_at'];

    protected $dates = ['updated_at', 'created_at'];


    public function appUser()
    {
        return $this->belongsTo('AppUser');
    }

}