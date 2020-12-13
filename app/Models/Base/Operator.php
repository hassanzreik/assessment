<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\OperatorCountry;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Operator
 * 
 * @property int $id
 * @property string $title
 * @property string $subscribe_url
 * @property string $unsubscribe_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|OperatorCountry[] $operator_countries
 * @property Collection|Subscription[] $subscriptions
 *
 * @package App\Models\Base
 */
class Operator extends Model
{
	use SoftDeletes;
	protected $table = 'operators';

	public function operator_countries()
	{
		return $this->hasMany(OperatorCountry::class);
	}

	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}
}
