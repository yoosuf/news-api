<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

	protected $fillable = ["name", "project_id"];

	protected $dates = ["due"];

	public static $rules = [
		"name" => "required",
		"project_id" => "numeric",
	];

	public function project()
	{
		return $this->belongsTo("App\\Project");
	}


}
