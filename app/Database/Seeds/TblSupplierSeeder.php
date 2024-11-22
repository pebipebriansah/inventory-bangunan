<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblSupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_supplier'  => 'SUP-001',
                'nama_supplier'=> 'Supplier A',
                'alamat'       => 'Jl. Merdeka No.1, Jakarta',
                'username'     => 'supplierA',
                'password'     => password_hash('12345', PASSWORD_DEFAULT), // Securely hash the password
                'kategori'     => 'Elektronik',
            ],
            [
                'id_supplier'  => 'SUP-002',
                'nama_supplier'=> 'Supplier B',
                'alamat'       => 'Jl. Sudirman No.10, Bandung',
                'username'     => 'supplierB',
                'password'     => password_hash('12345', PASSWORD_DEFAULT),
                'kategori'     => 'Peralatan Rumah Tangga',
            ],
            [
                'id_supplier'  => 'SUP-003',
                'nama_supplier'=> 'Supplier C',
                'alamat'       => 'Jl. Gajah Mada No.5, Surabaya',
                'username'     => 'supplierC',
                'password'     => password_hash('12345', PASSWORD_DEFAULT),
                'kategori'     => 'Bahan Baku',
            ],
        ];

        // Insert data into the database
        $this->db->table('tbl_supplier')->insertBatch($data);
    }
}
