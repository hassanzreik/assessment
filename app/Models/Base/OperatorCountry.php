<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Country;
use App\Models\Operator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OperatorCountry
 * 
 * @property int $id
 * @property int $operator_id
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Country $country
 * @property Operator $operator
 *
 * @package App\Models\Base
 */
class OperatorCountry extends Model
{
	protected $table = 'operator_countries';

	protected $casts = [
		'operator_id' => 'int',
		'country_id' => 'int'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function operator()
	{
		return $this->belongsTo(Operator::class);
	}
}
