<?php

namespace App\Models;

use App\Models\Base\OauthPersonalAccessClient as BaseOauthPersonalAccessClient;

class OauthPersonalAccessClient extends BaseOauthPersonalAccessClient
{
	protected $fillable = [
		'client_id'
	];
}
