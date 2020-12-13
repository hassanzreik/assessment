<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OauthAuthCode
 * 
 * @property string $id
 * @property int $user_id
 * @property string $client_id
 * @property string|null $scopes
 * @property bool $revoked
 * @property Carbon|null $expires_at
 *
 * @package App\Models\Base
 */
class OauthAuthCode extends Model
{
	protected $table = 'oauth_auth_codes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'revoked' => 'bool'
	];

	protected $dates = [
		'expires_at'
	];
}
