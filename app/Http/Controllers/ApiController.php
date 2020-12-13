<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Symfony\Component\HttpFoundation\Response as HTTP;
use Illuminate\Http\JsonResponse;

class ApiController extends BaseController
{

	public function __construct(){
	}

	public function respondCreated($message, $data=array())
	{
		return $this->respond([
				'status' => 'success',
				'status_code' => HTTP::HTTP_CREATED,
				'message' => $message,
				'data' => $data
		]);
	}
	public function respondSuccess($message, $data=array())
	{
		return $this->respond([
				'status' => 'success',
				'status_code' => HTTP::HTTP_OK,
				'message' => $message,
				'data' => $data
		]);
	}
	protected function respondWithPagination(Paginator $paginate, $data, $message)
	{
		$data = array_merge($data, [
				'paginator' => [
						'total_count'  => $paginate->total(),
						'total_pages' => ceil($paginate->total() / $paginate->perPage()),
						'current_page' => $paginate->currentPage(),
						'limit' => $paginate->perPage(),
				]
		]);
		return $this->respond([
				'status' => 'success',
				'status_code' => HTTP::HTTP_OK,
				'message' => $message,
				'data' => $data
		]);
	}
	public function respondNotFound($message = 'Not Found!')
	{
		return $this->respond([
				'status' => 'error',
				'status_code' => HTTP::HTTP_NOT_FOUND,
				'message' => $message,
		]);
	}
	public function respondInternalError($message)
	{
		return $this->respond([
				'status' => 'error',
				'status_code' => HTTP::HTTP_INTERNAL_SERVER_ERROR,
				'message' => $message,
		]);
	}
	public function respondValidationError($message, $data = array(), $statusCode = HTTP::HTTP_UNPROCESSABLE_ENTITY)
	{
		return $this->respond([
				'status' => 'error',
				'status_code' => $statusCode,
				'message' => $message,
				'data' => $data
		]);
	}
	public function respond($data)
	{
		if(!isset($data['status_code'])){
			$data['status_code'] = 400;
		}
		return response()->json($data, $data['status_code'])->header('Content-Type', 'application/json');
	}
	public function respondWithError($message, $statusCode = HTTP::HTTP_BAD_REQUEST)
	{
		return $this->respond([
				'status' => 'error',
				'status_code' => $statusCode,
				'message' => $message,
		]);
	}
}