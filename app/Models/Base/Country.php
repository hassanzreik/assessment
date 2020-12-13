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
 * Class Country
 * 
 * @property int $id
 * @property string $iso
 * @property string $name
 * @property string $title
 * @property string|null $iso3
 * @property int|null $numcode
 * @property int $phonecode
 * @property string $icon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $is_active
 * 
 * @property Collection|OperatorCountry[] $operator_countries
 * @property Collection|Subscription[] $subscriptions
 *
 * @package App\Models\Base
 */
class Country extends Model
{
	use SoftDeletes;
	protected $table = 'countries';

	protected $casts = [
		'numcode' => 'int',
		'phonecode' => 'int',
		'is_active' => 'int'
	];

	public function operator_countries()
	{
		return $this->hasMany(OperatorCountry::class);
	}

	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}
}
