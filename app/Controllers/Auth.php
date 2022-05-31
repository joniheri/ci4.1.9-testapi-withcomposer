<?php

namespace App\Controllers;

use App\Models\ModelUsers;
use App\Libraries\Hash;
use Firebase\JWT\JWT;

class Auth extends BaseController
{

  protected $session;

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

  // Function Register
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
    foreach ($getDataUsers as $loop1) { //CekUsernameDuplicate
      if ($loop1->username === $this->request->getVar('username')) {
        return view('register', ['message' => 'Username ' . $usernameInput . ' has been used']);
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
      'messageRegister' => 'Register Success',
    ];
    return view('register', $dataSuccess);
    // End RegisterSuccess
  }
  // End Function Register
  // ============================================

  public function processLogin()
  {
    // ValidationInput
    $validation = $this->validate([ //Valdation
      'username' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Username is required',
          'min_length' => 'Character input min 3 character',
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

    $getUsername = $this->ModelUsers->getUsername($dataInput); //Check username & password ada dan cocok di database

    if (!$getUsername || !password_verify($passwordInput, $getUsername[0]->password)) {
      $dataFailedLogin = [
        'validation' => $this->validator,
        'messageFailedLogin' => 'Username or password is wrong',
      ];
      return view('login', $dataFailedLogin);
      exit();
    }

    // LoginSuccess
    $secretKey = getenv('SECRET_KEY');
    $payload = [
      'iat' => 1356999524,
      'nbf' => 1357000000,
      'user_id' => $getUsername[0]->id,
      'username' => $getUsername[0]->username,
      'fullname' => $getUsername[0]->fullname,
      'password' => $getUsername[0]->password,
    ];
    $token = JWT::encode($payload, $secretKey, 'HS256');
    $dataSuccessLogin = [
      'status' => 'Response Success',
      'message' => 'Login Success',
      'token' => $token,
      'dataUser' => $payload,
    ];
    echo "  
      <script>
        localStorage.setItem('token', '" . $token . "');
      </script>
    ";
    $this->session->set_flashdata('data', 'jkdfkjasdf');
    redirect('auth/dashboarduser');
    // return redirect()->to('dashboarduser');
    // return view('admin/dashboard', $dataSuccessLogin);
    // End LoginSuccess

  }

  public function dashboardUser()
  {
    $dataGet = $this->session->flashdata('data');
    print_r($dataGet);
    exit();

    return view('admin/dashboard');
  }

  public function logout()
  {
    $dataSuccess = [
      'messageLogout' => 'Logout Success',
      'usernameSuccess' => '',
      'passwordSuccess' => '',
    ];
    // return view('login', $dataSuccess);
    return redirect('login');
  }

  public function template()
  {
    print_r('This is Function Template');
    exit();
  }
}
