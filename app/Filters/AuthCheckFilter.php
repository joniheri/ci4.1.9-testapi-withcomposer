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
	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param RequestInterface $request
	 * @param array|null       $arguments
	 *
	 * @return mixed
	 */

	public function before(RequestInterface $request, $arguments = null)
	{

		$secretKey = getenv('SECRET_KEY');
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
		}

		$token = explode(' ', $headerToken)[1];

		try {
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

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null        $arguments
	 *
	 * @return mixed
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//
	}
}
