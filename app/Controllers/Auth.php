<?php

namespace App\Controllers;

use App\Models\ModelUsers;
use App\Libraries\Hash;

class Auth extends BaseController
{

  function __construct()
  {
    $this->ModelUsers = new ModelUsers(); //Use this if u want call in all method in this class
    helper(['url', 'form']);
  }

  public function login()
  {
    return view('login');
  }

  public function register()
  {
    return view('register');
  }

  public function processLogin()
  {
    // ValidationInput
    $validation = $this->validate([ //Valdation
      'username' => [
        'rules' => 'required|min_length[3]|is_not_unique[user.username]',
        'errors' => [
          'required' => 'Username is required',
          'min_length' => 'Character input min 3 character',
          'is_not_unique' => 'This username is not registered',
        ],
      ],
      'password' => [
        'rules' => 'required|min_length[4]',
        'errors' => [
          'required' => 'Password is required',
          'min_length' => 'Character input min 4 character',
        ],
      ],

    ]);
    if (!$validation) {
      return view('login', ['validation' => $this->validator]);
      exit();
    }
    // End ValidationInput

    $usernameInput = $this->request->getVar('username'); //Data username From Input Form
    $passwordInput = $this->request->getVar('password'); //Data password From Input Form
    $dataInput = [
      'username' => $usernameInput,
      'password' => $passwordInput,
    ];

    $getLogin = $this->ModelUsers->getLogin($dataInput); //Check username & password ada dan cocok di database

    if (!$getLogin) {
      $dataFailedLogin = [
        'validation' => $this->validator,
        'message' => 'Wrong username or password'
      ];
      return view('login', $dataFailedLogin);
      exit();
    }

    // LoginSuccess
    $dataSuccess = [
      'loginSucces' => 'Login Success',
    ];
    return view('login', $dataSuccess);
    // End LoginSuccess
  }

  public function processRegister()
  {

    // ValidationInput
    $validation = $this->validate([ //Valdation
      'username' => [
        'rules' => 'required|min_length[3]',
        'errors' => [
          'required' => 'Username is required',
          'min_length' => 'Character input min 3 character'
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
    // End CheckDuplicateUsername

    foreach ($getDataUsers as $loop1) { //CekUsernameDuplicate
      if ($loop1->username === $this->request->getVar('username')) {
        return view('register', ['message' => 'Username ' . $usernameInput . ' sudah ada']);
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

    if ($this->ModelUsers->addData($dataAdd) <= 0) { //Check if insert date to database Failed
      return view('register', ['validation' => $this->validator]);
      exit();
    }

    // RegisterSuccess
    $dataSuccess = [
      'registerSucces' => 'Register Success',
      'usernameSuccess' => '',
      'passwordSuccess' => '',
    ];
    return view('register', $dataSuccess);
    // End RegisterSuccess
  }

  public function dashboardUser()
  {
    return view('admin/dashboard');
  }

  public function processLogout()
  {
    print_r('This is Function processLogout');
    exit();
  }

  public function template()
  {
    print_r('This is Function Template');
    exit();
  }
}
