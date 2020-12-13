<?php

namespace App\Http\Middleware;

use App\Helpers\JWTHelper;
use Closure;
use Illuminate\Http\Request;
use Mockery\Exception;

class ServerMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 * @throws \Exception
	 */
    public function handle(Request $request, Closure $next)
    {
    	try{
    		$token = $request->bearerToken();

    		if(empty($token)) throw new \Exception("Invalid Token",401);

    		$data = (new JWTHelper())->decode($token);

    		// add token data in request and pass it to action
    		$request->merge((array)$data);


    		return $next($request);
	    }catch (Exception $e){
		    $data = [
				    'status' => 'error',
				    'status_code' => $e->getCode(),
				    'message' => $e->getMessage(),
		    ];
		    return response()->json($data, 401)->header('Content-Type', 'application/json');
	    }
    }
}
