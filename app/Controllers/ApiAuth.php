<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelUsers;
use App\Libraries\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiAuth extends BaseController
{
  use ResponseTrait; //Use this if you make API

  function __construct()
  {
    $this->ModelUsers = new ModelUsers(); //Use this if u want call in all method in this class
    helper(['url', 'form']);
  }

  // End Function Register
  public function register()
  {

    // ValidationInput
    $validation = $this->validate([ //Valdation
      'username' => [
        'rules' => 'required|min_length[3]',
        'errors' => [
          'required' => 'Username is required',
          'min_length' => 'Username min 3 character'
        ],
      ],
      'password' => [
        'rules' => 'required|min_length[4]',
        'errors' => [
          'required' => 'Password is required',
          'min_length' => 'Password min 4 character',
        ],
      ],
      'cpassword' => [
        'rules' => 'required|min_length[4]|matches[password]',
        'errors' => [
          'required' => 'Confirm password is required',
          'min_length' => 'Confirm password min 4 character',
          'matches' => 'Confirm password not match',
        ],
      ],
    ]);

    if (!$validation) {
      return $this->respond([
        'status' => 'Response Fail',
        'message' => 'Register Failed',
        'error' =>  $this->validator->getErrors(),
      ]);
      exit();
    }

    $usernameInput = $this->request->getVar('username'); //Username From Input
    $passwordInput = $this->request->getVar('cpassword'); //Username From Input

    // CheckDuplicateUsername
    $getDataUsers = $this->ModelUsers->getData(); //Get ALl Data User
    foreach ($getDataUsers as $loop1) { //CekUsernameDuplicate
      if ($loop1->username === $usernameInput) {
        return $this->respond([
          'status' => 'Response Fail',
          'message' => 'Username ' . $usernameInput . ' has been used',
        ]);
        exit();
      }
    }
    // End CheckDuplicateUsername

    $dataAdd = [ //Data Input From Input Form
      'username' => $usernameInput,
      'password' => Hash::make($passwordInput),
      'created_at' => date('Y-m-d h:i:s'),
      'updated_at' => date('Y-m-d h:i:s'),
    ];

    if (!$this->ModelUsers->addData($dataAdd)) { //Check if insert date to database Failed
      return $this->respond([
        'status' => 'Response Fail',
        'message' => 'Register Failed',
      ]);
      exit();
    }

    // RegisterSuccess
    return $this->respond([
      'status' => 'Response Success',
      'message' => 'Register Success',
      'dataRegister' => $dataAdd,
    ]);
    // ENd RegisterSuccess

  }
  // End Function Register
  // ============================================

  // Function Login
  public function login()
  {

    $usernameInput = $this->request->getVar('username'); //Data username From Input Form
    $passwordInput = $this->request->getVar('password'); //Data password From Input Form
    if (empty($usernameInput)) {
      return $this->respond([
        'status' => 'Response Failed',
        'message' => 'Username tidak boleh kosong',
      ]);
    } else if (empty($passwordInput)) {
      return $this->respond([
        'status' => 'Response Failed',
        'message' => 'Password tidak boleh kosong',
      ]);
    }

    $dataInput = [
      'username' => $usernameInput,
      'password' => $passwordInput,
    ];
    $getUsername = $this->ModelUsers->getUsername($dataInput); //Check username & password ada dan cocok di database

    if (!empty($getUsername) && password_verify($passwordInput, $getUsername[0]->password)) {

      $secretKey = getenv('SECRET_KEY');

      $issuer = 'THE_ISSUER';
      $audience = 'THE_AUDIENCE';

      $payload = [
        'iat' => 1356999524,
        'nbf' => 1357000000,
        'user_id' => $getUsername[0]->id,
        'fullname' => $getUsername[0]->fullname,
        'password' => $getUsername[0]->password,
      ];

      $token = JWT::encode($payload, $secretKey, 'HS256');
      return $this->respond([
        'status' => 'Response Success',
        'message' => 'Login Success',
        'dataUser' => $token,
      ]);
    } else {
      return $this->respond([
        'status' => 'Response Failed',
        'message' => 'Username or password si wrong',
      ]);
    }
  }
  // End Function Login
  // ============================================


  // Function Check
  public function currentUserLogin()
  {
    $secretKey = getenv('SECRET_KEY');
    $headerToken = $this->request->getServer('HTTP_AUTHORIZATION');

    if (!$headerToken) return $this->failUnauthorized('Token Required'); //Check token must be required

    $token = explode(' ', $headerToken)[1];

    try {
      $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
      return $this->respond([
        'status' => 'Respons Success',
        'dataTokent' => $decoded,
      ]);
    } catch (\Throwable $th) {
      return $this->fail([
        'status' => 'Response Fail',
        'message' => 'Invalid Token',
      ]);
    }
  }
  // End Function Logout
  // ============================================

  // Function logout
  public function logout()
  {
    return $this->respond([
      'status' => 'Response Success',
      'message' => 'Logout Success',
    ]);
  }
  // End Function Logout
  // ============================================

  // Function Template
  public function template()
  {
    $data = [
      'id' => '1',
      'name' => 'Jon Heri',
    ];

    return $this->respond([
      'status' => 'Response Success',
      'message' => 'Cek data Success',
      'data' => [
        'data' => $data,
      ],
    ]);
  }
  // End Function Logout
  // ============================================
}
