<?php

namespace App\Models;

use App\Models\Base\OauthRefreshToken as BaseOauthRefreshToken;

class OauthRefreshToken extends BaseOauthRefreshToken
{
	protected $fillable = [
		'access_token_id',
		'revoked',
		'expires_at'
	];
}
