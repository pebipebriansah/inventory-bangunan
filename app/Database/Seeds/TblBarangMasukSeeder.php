<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblBarangMasukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_barang_masuk' => 'BM001',
                'id_pesanan'      => 'PO001',
                'tanggal_masuk'   => '2024-11-22 10:00:00',
            ],
            [
                'id_barang_masuk' => 'BM002',
                'id_pesanan'      => 'PO002',
                'tanggal_masuk'   => '2024-11-22 11:00:00',
            ],
            [
                'id_barang_masuk' => 'BM003',
                'id_pesanan'      => 'PO003',
                'tanggal_masuk'   => '2024-11-22 12:00:00',
            ],
        ];

        // Insert data into the table
        $this->db->table('tbl_barang_masuk')->insertBatch($data);
    }
}
