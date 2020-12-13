<?php

namespace App\Models;

use App\Models\Base\OperatorCountry as BaseOperatorCountry;

class OperatorCountry extends BaseOperatorCountry
{
	protected $fillable = [
		'operator_id',
		'country_id'
	];
}
