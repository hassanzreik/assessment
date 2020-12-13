<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Country;
use App\Models\Operator;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subscription
 * 
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $operator_id
 * @property int $country_id
 * @property string|null $mobile_number
 * @property string|null $status
 * @property Carbon $expiry_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Country $country
 * @property Operator $operator
 * @property Product $product
 * @property User $user
 *
 * @package App\Models\Base
 */
class Subscription extends Model
{
	use SoftDeletes;
	protected $table = 'subscriptions';

	protected $casts = [
		'user_id' => 'int',
		'product_id' => 'int',
		'operator_id' => 'int',
		'country_id' => 'int'
	];

	protected $dates = [
		'expiry_date'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function operator()
	{
		return $this->belongsTo(Operator::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
