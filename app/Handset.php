<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Handset extends Model {

	protected $fillable = ['device_type', 'device_id', 'push_token'];

	protected $hidden = ['updated_at', 'created_at', 'id'];

	protected $dates = ['updated_at', 'created_at'];

	public static $rules = [
		'device_type' => 'required',
		'device_id' => 'required',
	];


}
