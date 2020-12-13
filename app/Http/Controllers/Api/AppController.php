<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\OperatorResource;
use App\Http\Resources\ProductResource;
use App\Models\Operator;
use App\Models\Product;
use Exception;

class AppController extends ApiController
{
    //
	public function getProducts()
	{
		try{
			return parent::respondSuccess('success', ProductResource::collection(
					Product::all()
			));
		}catch (Exception $e){
			return parent::respondWithError($e->getMessage());
		}
	}
	public function getOperators()
	{
		try{
			return parent::respondSuccess('success', OperatorResource::collection(
					Operator::with('countries')->get()
			));
		}catch (Exception $e){
			return parent::respondWithError($e->getMessage());
		}
	}
}
