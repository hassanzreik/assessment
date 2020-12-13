<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Exception;
use ErrorException;
use ReflectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

	public function render($request, $e)
	{
		$error = array();

		if($e instanceof ValidationException) {
			$code = $e->status;
			$error = $e->errors();
			$message = $e->getMessage();
		}elseif($e instanceof NotFoundHttpException) {
			$code = $e->getStatusCode()?? $e->getCode();
			$message = $e->getMessage()??"Page not found.";
		}elseif($e instanceof ReflectionException) {
			$code = 500;
			$message = $e->getMessage()??"Page not found.";
		}elseif($e instanceof ErrorException) {
			$code = 500;
			$message = $e->getMessage()??"Page not found.";
		}elseif($e instanceof Exception) {
			$code = 500;
			if($e->getCode()) $code = $e->getCode();
			$message = $e->getMessage()??"Page not found.";
		}else{
			$message = $e->getMessage()??"Page not found.";
			$code = $e->getCode()??400;
		}

		if ($request->is('api/*') || $request->wantsJson()) {
			$data = [
					'status' => 'error',
					'status_code' => $code,
					'message' => $message,
					'data'=> $error
			];

			return response()->json($data, $data['status_code']);
		}

		return parent::render($request, $e);
	}
}
