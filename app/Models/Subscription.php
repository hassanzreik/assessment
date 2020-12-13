<?php

namespace App\Models;

use App\Models\Base\Subscription as BaseSubscription;

class Subscription extends BaseSubscription
{
	protected $fillable = [
		'user_id',
		'product_id',
		'operator_id',
		'country_id',
		'mobile_number',
		'status',
		'expiry_date'
	];
}
