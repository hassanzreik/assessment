<?php

namespace App\Models;

use App\Models\Base\OauthClient as BaseOauthClient;

class OauthClient extends BaseOauthClient
{
	protected $hidden = [
		'secret'
	];

	protected $fillable = [
		'user_id',
		'name',
		'secret',
		'provider',
		'redirect',
		'personal_access_client',
		'password_client',
		'revoked'
	];
}
