<?php


namespace App\Helpers;


use App\Models\ApiLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Helper
{

	public static function generateJWTToken($subscription){
		$payload = array(
				"iss" => Config::get('app.url'),
				"aud" => Config::get('app.server_url'),
				"sub" => "assessment-test",
				"iat" => strtotime(now()),
				"exp" => strtotime(now()->addHours(24)) ,
				"nbf" => strtotime(now()),
				"jti" => uniqid(),
				"userId" => Auth::id(),
				"subscriptionId" => $subscription->id,
				"msisdn" => $subscription->mobile_number,
				"operatorId" => $subscription->operator_id,
		);
		$jwt = new JWTHelper();
		return $jwt->encode($payload);
	}

	public static function log($url,$method,$request = [],$response = [], $statusCode = ""){
		$apiLog = new ApiLog();
		$apiLog->url = $url;
		$apiLog->method = $method;
		$apiLog->request = $request;
		$apiLog->response = $response;
		$apiLog->status_code = $statusCode;
		$apiLog->save();
		return $apiLog;
	}
}