<?php

namespace App\Models;

use App\Models\Base\Operator as BaseOperator;

class Operator extends BaseOperator
{
	protected $fillable = [
		'title',
		'subscribe_url',
		'unsubscribe_url'
	];


	public function countries()
	{
		return $this->belongsToMany(Country::class, 'operator_countries')
				->withPivot('id')
				->withTimestamps();
	}
}
