<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\ApiController;
use App\Http\Resources\SubscriptionResource;
use App\Http\Resources\UserResource;
use App\Models\Operator;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    //
	public function __construct()
	{
		parent::__construct();
	}

	public function login(Request $request)
	{
		if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
			$user = Auth::user();
			$data['user_token'] = $user->createToken('api_call')->accessToken;
			$data['user'] = UserResource::make($user);
			return parent::respondSuccess('success', $data);
		} else {
			return parent::respondValidationError("Wrong Credentials");
		}
	}

	public function logout()
	{
		if (Auth::check()) {
			$user = Auth::user()->token();
			$user->revoke();
			$return['message'] = "Logged out";
			$return['success'] = true;
			return parent::respondSuccess($return['message']);
		} else {
			return parent::respondWithError(trans('messages.token_not_found'));
		}
	}

	public function register(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),
					[
							'name' => 'required',
							'email' => 'required|email|unique:users,email',
							'password' => 'required',
							'c_password' => 'required|same:password',
					]);

			if ($validator->fails()) {
				return parent::respondValidationError("Registration Error", $validator->errors());
			}

			$user = new User();
			$user->name = $request->name;
			$user->email = $request->email;
			$user->password = bcrypt($request->password);
			$user->email_verified_at = now();
			$user->save();

			$data['user_token'] = $user->createToken('api_call')->accessToken;
			$data['user'] = new UserResource($user);
			return parent::respondSuccess('success', $data);
		}catch (Exception $e){
			return parent::respondWithError($e->getMessage());
		}
	}

	public function profile(){
		if (Auth::check()) {
			return parent::respondSuccess('success', UserResource::make(Auth::user()));
		} else {
			return parent::respondWithError(trans('messages.token_not_found'));
		}
	}

	public function subscribe(Request $request){

		try {
			$validator = Validator::make($request->all(),
					[
							'mobile_number' => 'required',
							'operator_id' => 'required|integer',
							'product_id' => 'required|integer',
					]);

			if ($validator->fails()) {
				return parent::respondValidationError("Subscription Error", $validator->errors());
			}

			$operator = Operator::find($request->operator_id);
			if (empty($operator)) throw new Exception("Invalid operator");

			$product = Product::find($request->product_id);
			if (empty($product)) throw new Exception("Invalid product");

			// always add + to mobile number to validate it in server subscribe api
			$request->mobile_number = "+".((int)str_replace(" ", "", $request->mobile_number));

			$subscription = new Subscription();
			$subscription->user_id = Auth::id();
			$subscription->operator_id = $operator->id;
			$subscription->product_id = $product->id;
			$subscription->mobile_number = $request->mobile_number;
			$subscription->status = "pending"; // 'pending', 'subscribed', 'cancelled', 'invalid'
			$subscription->save();

			$token = Helper::generateJWTToken($subscription);

			// request logs
			$apiLog = Helper::log(url($operator->subscribe_url)."/$token", "GET");

			$response = Http::withToken($token)
					->withHeaders(['Accept' => 'application/json'])
					->get($apiLog->url);

			$apiLog->response = $response->json();
			$apiLog->status_code = $response->status();
			$apiLog->save();

			if($response->ok() && !empty($response->json())){

				$subscription->status = "subscribed";
				$subscription->expiry_date = now()->addDays($product->period_in_days);
				$subscription->save();


				return parent::respondSuccess('success',SubscriptionResource::make($subscription));
			}else{
				$subscription->status = "invalid";
				$subscription->save();
				$message = isset($response->json()['message']) && !empty($response->json()['message']) ? $response->json()['message'] : "please contact us";
				throw new Exception($message,400);
			}
		}catch (Exception $e){

			return parent::respondWithError($e->getMessage());
		}
	}

	public function unsubscribe(Request $request){

		try {
			$validator = Validator::make($request->all(),
					[
							'subscription_id' => 'required',
					]);

			if ($validator->fails()) {
				return parent::respondValidationError("Unsubscription Error", $validator->errors());
			}

			$subscription = Subscription::where('id',$request->subscription_id)
						->where('user_id',Auth::id())
					->whereDate('expiry_date','>',now())->first();
			if(empty($subscription)) throw new Exception('Invalid Subscription');

			$token = Helper::generateJWTToken($subscription);

			// request logs
			$apiLog = Helper::log(url($subscription->operator->unsubscribe_url)."/$token", "GET");

			$response = Http::withToken($token)
					->withHeaders(['Accept' => 'application/json'])
					->get($apiLog->url);

			$apiLog->response = $response->json();
			$apiLog->status_code = $response->status();
			$apiLog->save();

			if($response->ok() && !empty($response->json())){

				$subscription->status = "cancelled";
				$subscription->save();

				return parent::respondSuccess('Unsubscription success',[]);
			}else{
				$message = isset($response->json()['message']) && !empty($response->json()['message']) ? $response->json()['message'] : "Something went wrong";
				throw new Exception($message,400);
			}
		}catch (Exception $e){
			return parent::respondWithError($e->getMessage());
		}
	}

}
