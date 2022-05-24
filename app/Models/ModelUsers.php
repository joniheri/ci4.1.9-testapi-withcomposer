<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUsers extends Model
{
  protected $table = 'user';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;

  public function getData()
  {
    $getData = $this->db->query(
      "
        SELECT * FROM ged_ms.user tbUser ORDER BY tbUser.id DESC
      "
    );
    return $getData->getResult();
  }

  public function getDataLogin($dataInput)
  {
    $usernameInput = $dataInput['username'];
    $passwordInput = $dataInput['password'];

    $getData = $this->db->query(
      "
        SELECT * FROM ged_ms.user tbuser
        WHERE tbuser.username ='$usernameInput' AND tbuser.password ='$passwordInput'
      "
    );

    print_r($getData);
    exit();
    return $getData->getResult();
  }

  public function addData($data)
  {

    $username = "";
    $password = "";
    $fullname = "";
    $address = "";
    $created_at = $data['created_at'];
    $updated_at = $data['updated_at'];

    if (isset($data['username'])) {
      $username = $data['username'];
    }

    if (isset($data['password'])) {
      $password = $data['password'];
    }

    if (isset($data['fullname'])) {
      $fullname = $data['fullname'];
    }

    if (isset($data['address'])) {
      $address = $data['address'];
    }

    $saveData = $this->db->query(
      "
        INSERT INTO ged_ms.user (
          username,
          password,
          fullname,
          address,
          created_at,
          updated_at
        ) VALUES (
          '$username',
          '$password',
          '$fullname',
          '$address',
          '$created_at',
          '$updated_at'
        )
      "
    );
    return $this->db->affectedRows();
  }

  public function template()
  {
    return 'This is template function';
  }
}
