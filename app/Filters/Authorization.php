<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class Authorization implements FilterInterface
{

  public function before(RequestInterface $request, $arguments = null)
  {

    $headerHttp = $request->getServer('HTTP_AUTHORIZATION');
    $tokenFromSession = '';

    if (!empty($headerHttp)) {
      try {
        $token = explode(' ', $headerHttp)[1];
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
    } else if (!empty($tokenFromSession)) {
      try {
        $secretKey = getenv('SECRET_KEY');
        JWT::decode($tokenFromSession, new Key($secretKey, 'HS256'));
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
    } else {
      return Services::response()
        ->setJSON(
          [
            'status' => 'Response Success',
            'message' => 'Token must be required',
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
