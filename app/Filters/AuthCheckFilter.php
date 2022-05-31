<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class AuthCheckFilter implements FilterInterface
{

	public function before(RequestInterface $request, $arguments = null)
	{

		$headerToken = $request->getServer('HTTP_AUTHORIZATION');
		if (!$headerToken) {
			return Services::response()
				->setJSON(
					[
						'status' => 'Response Fail',
						'message' => 'Token must be Required',
					]
				)
				->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
			exit();
		}

		try {
			$token = explode(' ', $headerToken)[1];
			$secretKey = getenv('SECRET_KEY');
			JWT::decode($token, new Key($secretKey, 'HS256'));
		} catch (\Throwable $th) {
			return Services::response()
				->setJSON(
					[
						'status' => 'Response Fail',
						'message' => 'Invalid Token',
					]
				)
				->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//
	}
}
