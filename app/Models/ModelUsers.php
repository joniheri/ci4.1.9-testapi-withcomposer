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

  public function getLogin($dataInput)
  {
    $usernameInput = $dataInput['username'];
    $passwordInput = $dataInput['password'];

    $getData = $this->db->query(
      "
        SELECT * FROM ged_ms.user tbuser
        WHERE tbuser.username ='$usernameInput' AND tbuser.password ='$passwordInput'
      "
    );

    return $getData->getResult();
  }

  public function addData($dataAdd)
  {

    $username = "";
    $password = "";
    $fullname = "";
    $address = "";
    $created_at = $dataAdd['created_at'];
    $updated_at = $dataAdd['updated_at'];

    if (isset($dataAdd['username'])) {
      $username = $dataAdd['username'];
    }

    if (isset($dataAdd['password'])) {
      $password = $dataAdd['password'];
    }

    if (isset($data['fullname'])) {
      $fullname = $dataAdd['fullname'];
    }

    if (isset($data['address'])) {
      $address = $dataAdd['address'];
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
