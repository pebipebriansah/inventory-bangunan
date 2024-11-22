<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblBarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_barang'   => 'BRG001',
                'nama_barang' => 'Laptop',
                'stok'        => '50',
                'harga'       => '15000000',
                'id_supplier' => 'SUP001',
            ],
            [
                'id_barang'   => 'BRG002',
                'nama_barang' => 'Smartphone',
                'stok'        => '200',
                'harga'       => '5000000',
                'id_supplier' => 'SUP002',
            ],
            [
                'id_barang'   => 'BRG003',
                'nama_barang' => 'Keyboard',
                'stok'        => '100',
                'harga'       => '250000',
                'id_supplier' => 'SUP001',
            ],
        ];

        // Insert data into the database
        $this->db->table('tbl_barang')->insertBatch($data);
    }
}
