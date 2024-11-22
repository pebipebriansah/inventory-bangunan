<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblBarangSupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_barang_supplier' => 'SUP001',
                'nama_barang'        => 'Laptop',
                'stok'               => '50',
                'harga'              => '15000000',
                'id_supplier'        => 'S001',
            ],
            [
                'id_barang_supplier' => 'SUP002',
                'nama_barang'        => 'Printer',
                'stok'               => '20',
                'harga'              => '3000000',
                'id_supplier'        => 'S002',
            ],
            [
                'id_barang_supplier' => 'SUP003',
                'nama_barang'        => 'Mouse',
                'stok'               => '100',
                'harga'              => '150000',
                'id_supplier'        => 'S003',
            ],
        ];

        // Insert data into the database
        $this->db->table('tbl_barang_supplier')->insertBatch($data);
    }
}
