<?php

namespace App\Models;

use App\Models\Base\Product as BaseProduct;

class Product extends BaseProduct
{
	protected $fillable = [
		'title',
		'price',
		'period_in_days',
		'is_active'
	];
}
