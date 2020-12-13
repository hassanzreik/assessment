<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\ApiController;
use App\Models\Operator;
use App\Models\Subscription;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;


class SubscribeController extends ApiController
{
    //

	public function subscribeCallback(Request $request)
	{
		try{

			// validate mobile number

			if(!isset($request->msisdn) || empty($request->msisdn)) throw new Exception("MSISDN missing");

			//This library based on https://github.com/google/libphonenumber
			// validates international phone numbers

			$request->msisdn = "+".((int)$request->msisdn);
			$msisdn = PhoneNumber::make($request->msisdn);

			if($mobileNumber = $msisdn->getPhoneNumberInstance() && $msisdn->isOfType('mobile')) {

				$operator = Operator::find($request->operatorId);
				if (empty($operator)) throw new Exception("Invalid operator");

				if(!in_array($msisdn->getCountry(), $operator->countries->pluck('iso')->toArray())) throw new Exception("Invalid MSISDN for this operator");

				$user = User::find($request->userId);

				$data = ['success'=>true,'message'=>'you are subscribed now'];
				if (empty($user)) throw new Exception("Invalid user");

				//server logs
//				$apiLog = new ApiLog();
//				$apiLog->url = "server log";
//				$apiLog->method = $request->method();
//				$apiLog->request = $request->all();
//				$apiLog->response = $data;
//				$apiLog->save();

				return parent::respondSuccess('success', $data);
			}else{
				throw new Exception("Invalid MSISDN");
			}
		}catch (Exception $e){

			return parent::respondWithError($e->getMessage());
		}
	}

	public function unsubscribeCallback(Request $request)
	{
		try{
			if(!isset($request->subscriptionId) || empty($request->subscriptionId)) throw new Exception("Subscription id missing");

			$subscription = Subscription::find($request->subscriptionId);
			if(empty($subscription)) throw new Exception("Invalid Subscription");

			$data = ['success'=>true,'message'=>'you are unsubscribed now'];

			return parent::respondSuccess('success', $data);
		}catch (Exception $e){

			return parent::respondWithError($e->getMessage());
		}
	}
}
