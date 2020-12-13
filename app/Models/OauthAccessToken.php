<?php

namespace App\Models;

use App\Models\Base\OauthAccessToken as BaseOauthAccessToken;

class OauthAccessToken extends BaseOauthAccessToken
{
	protected $fillable = [
		'user_id',
		'client_id',
		'name',
		'scopes',
		'revoked',
		'expires_at'
	];
}
