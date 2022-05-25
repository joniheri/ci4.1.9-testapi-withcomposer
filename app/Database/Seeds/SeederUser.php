<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use App\Libraries\Hash;

use function PHPSTORM_META\sql_injection_subst;

class SeederUser extends Seeder
{
    public function run()
    {
        $sqlCheckDuplicateUsername = $this->db->query("
            SELECT tbuser.username FROM ged_ms.user tbuser WHERE tbuser.username='admin'
        ");
        $data = [
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'fullname' => 'Jon Heri',
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];

        $this->db->query(
            "
            INSERT INTO user (
                    username, 
                    password, 
                    fullname,
                    created_at,
                    updated_at
                ) VALUES(
                    :username:, 
                    :password:, 
                    :fullname:,
                    :created_at:,
                    :updated_at:
                )
            ",
            $data
        );
    }
}
