<?php

namespace App\Models;

use App\Models\Base\ApiLog as BaseApiLog;

class ApiLog extends BaseApiLog
{
	protected $fillable = [
		'url',
		'method',
		'status_code',
		'request',
		'response'
	];
}
