<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblBarangKeluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang_keluar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'id_penjualan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'tanggal_keluar' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('id_barang_keluar', true);

        // Create the table
        $this->forge->createTable('tbl_barang_keluar');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('tbl_barang_keluar', true);
    }
}
