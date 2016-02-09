<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Handset extends Model {

	protected $fillable = ['device_type', 'device_id', 'push_token'];

	protected $hidden = ['updated_at', 'created_at', 'id'];

	protected $dates = ['updated_at', 'created_at'];



	protected static function boot()
	{
		parent::boot();

		static::saving(function ($model)
		{
			$model->generateAccessToken();
		});
	}


	protected function generateAccessToken()
	{
		$this->attributes['access_token'] = bin2hex(openssl_random_pseudo_bytes(256));


		if( is_null($this->attributes['access_token']) )
			return false;
		else
			return true;
	}


}
