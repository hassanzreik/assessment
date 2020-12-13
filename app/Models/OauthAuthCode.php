<?php

namespace App\Models;

use App\Models\Base\OauthAuthCode as BaseOauthAuthCode;

class OauthAuthCode extends BaseOauthAuthCode
{
	protected $fillable = [
		'user_id',
		'client_id',
		'scopes',
		'revoked',
		'expires_at'
	];
}
