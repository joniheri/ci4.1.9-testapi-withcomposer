<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelUsers;

class ApiUsers extends BaseController
{
  use ResponseTrait; //Use this if you make API

  function __construct()
  {
    $this->ModelUsers = new ModelUsers(); //Use this if u want call in all method in this class
  }

  public function index()
  {
    // $data = $this->ModelUsers->getData(); //Get data from ModelUsers

    // if ($data <= null) { //If data empty 
    //   return $this->respond([
    //     'status' => 'Response Failed',
    //     'error' => 202,
    //     'message' => 'Data is Empty',
    //   ]);
    //   exit();
    // }

    return $this->respond([ //If data not Empty
      'status' => 'Response Success',
      'error' => null,
      'message' => [
        'success' => 'Get data Success',
        'data' => 'This is data',
      ],
    ]);
  }

  public function create()
  {

    $getDataUsers = $this->ModelUsers->getData(); //Get ALl Data User
    $usernameInput = $this->request->getVar('username'); //Data Username From Input Form

    foreach ($getDataUsers as $loop1) { //CekUsernameDuplicate
      if ($loop1->username === $this->request->getVar('username')) {
        echo "username " . $usernameInput . " Sudah Ada";
        exit();
      } else {
        echo "Username " . $usernameInput . " Belum Ada";
        exit();
      }
    }

    $dataAdd = [ //Data Input From Input Form
      'username' => $this->request->getVar('username'),
      'password' => $this->request->getVar('password'),
      'fullname' => $this->request->getVar('fullname'),
      'address' => $this->request->getVar('address'),
      'created_at' => date('Y-m-d h:i:s'),
      'updated_at' => date('Y-m-d h:i:s'),
    ];

    if ($this->ModelUsers->addData($dataAdd) <= 0) { //Check if insert date to database Failed
      return $this->respond([
        'status' => 'Response Success',
        'message' => 'Add data Failed!'
      ]);
      exit();
    }

    $dataAfterAdd = $this->ModelUsers->getData(); //Get all data after insert new data

    return $this->respond([ //Response
      'status' => 'Response Success',
      'dataAdded' => $dataAdd,
      'message' => [
        'success' => 'Input data Success',
        'data' => $dataAfterAdd,
      ],
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
