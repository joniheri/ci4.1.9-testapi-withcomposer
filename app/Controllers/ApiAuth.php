<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelUsers;

class ApiAuth extends BaseController
{
  use ResponseTrait; //Use this if you make API

  function __construct()
  {
    $this->ModelUsers = new ModelUsers(); //Use this if u want call in all method in this class
    helper(['url', 'form']);
  }

  public function formLogin()
  {
    return view('login');
  }

  public function formRegister()
  {
    return view('register');
  }

  public function processLogin()
  {

    $usernameInput = $this->request->getVar('username'); //Data username From Input Form
    $passwordInput = $this->request->getVar('password'); //Data password From Input Form
    $dataInput = [
      'username' => $usernameInput,
      'password' => $passwordInput,
    ];

    $validation = $this->validate([
      'username' => 'required',
      'password' => 'required|min_length[4]|max_length[30]',
    ]);
    if (!$validation) {
      return view('login', ['validation' => $this->validator]);
    }

    $getDataLogin = $this->ModelUsers->getDataLogin($dataInput); //Get ALl Data User
    // print_r($getDataLogin);
    // exit();

    return $this->respond([
      'status' => 'Response Success',
      'message' => 'Login Success',
    ]);
  }

  public function processRegister()
  {

    // ValidationInput
    $validation = $this->validate([ //Valdation
      'username' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Username is required',
        ],
      ],
      'password' => [
        'rules' => 'required|min_length[4]',
        'errors' => [
          'required' => 'Password is required',
          'min_length' => 'Character input min 4 character',
        ],
      ],
      'cpassword' => [
        'rules' => 'required|min_length[4]|matches[password]',
        'errors' => [
          'required' => 'Confirm password is required',
          'min_length' => 'Character input min 4 character',
          'matches' => 'Confirm password not match',
        ],
      ],

    ]);

    if (!$validation) {
      return view('register', ['validation' => $this->validator]);
      exit();
    }
    // End ValidationInput

    // CheckDuplicateUsername
    $getDataUsers = $this->ModelUsers->getData(); //Get ALl Data User
    $usernameInput = $this->request->getVar('username'); //Data Username From Input Form
    $passwordInput = $this->request->getVar('password'); //Data Username From Input Form

    foreach ($getDataUsers as $loop1) { //CekUsernameDuplicate
      if ($loop1->username === $this->request->getVar('username')) {
        return view('register', ['duplicateUsername' => 'Username ' . $usernameInput . ' sudah ada']);
        exit();
      }
    }
    // End CheckDuplicateUsername

    $dataAdd = [ //Data Input From Input Form
      'username' => $usernameInput,
      'password' => $passwordInput,
      'created_at' => date('Y-m-d h:i:s'),
      'updated_at' => date('Y-m-d h:i:s'),
    ];

    if ($this->ModelUsers->addData($dataAdd) <= 0) { //Check if insert date to database Failed
      return view('register', ['validation' => $this->validator]);
      exit();
    }

    // RegisterSuccess
    return view('register', ['registerSucces' => 'Register Success']);
    // End RegisterSuccess
  }

  public function dashboardUser()
  {
    return view('admin/dashboard');
  }

  public function processLogout()
  {
    return $this->respond([
      'status' => 'Response Success',
      'message' => 'Logout Success',
    ]);
  }

  public function template()
  {
    $data = [
      'id' => '1',
      'name' => 'Jon Heri',
    ];

    return $this->respond([
      'status' => 'Response Success',
      'message' => 'Cek data Success',
      'error' => null,
      'data' => [
        'data' => $data,
      ],
    ]);
  }
}
