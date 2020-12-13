<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ApiLog
 * 
 * @property int $id
 * @property string $url
 * @property string $method
 * @property string $status_code
 * @property array|null $request
 * @property array|null $response
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models\Base
 */
class ApiLog extends Model
{
	use SoftDeletes;
	protected $table = 'api_logs';

	protected $casts = [
		'request' => 'json',
		'response' => 'json'
	];
}
