<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user'      => 1,
                'nama_lengkap' => 'Admin User',
                'username'     => 'admin',
                'password'     => password_hash('12345', PASSWORD_DEFAULT), // Use password_hash to securely hash the password
                'role'         => 'admin',
            ],
            [
                'id_user'      => 2,
                'nama_lengkap' => 'Manager User',
                'username'     => 'manager',
                'password'     => password_hash('12345', PASSWORD_DEFAULT),
                'role'         => 'manager',
            ],
            [
                'id_user'      => 3,
                'nama_lengkap' => 'Gudang User',
                'username'     => 'gudang',
                'password'     => password_hash('12345', PASSWORD_DEFAULT),
                'role'         => 'gudang',
            ],
        ];

        // Insert data into the database
        $this->db->table('tbl_user')->insertBatch($data);
    }
}
