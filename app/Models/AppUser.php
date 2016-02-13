<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class AppUser extends Model
{
    protected $fillable = ['email', 'mobile', 'first_name', 'last_name'];

    protected $hidden = ['updated_at', 'created_at'];

    protected $dates = ['updated_at', 'created_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function handsets()
    {
        return $this->hasMany('Handset');
    }

    public function socialProfiles()
    {
        return $this->hasMany('SocialProvider');
    }

}