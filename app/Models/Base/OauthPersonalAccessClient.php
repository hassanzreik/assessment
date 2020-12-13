<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OauthPersonalAccessClient
 * 
 * @property int $id
 * @property string $client_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class OauthPersonalAccessClient extends Model
{
	protected $table = 'oauth_personal_access_clients';
}
