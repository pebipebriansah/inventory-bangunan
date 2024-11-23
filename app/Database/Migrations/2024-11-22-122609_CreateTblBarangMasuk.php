<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblBarangMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang_masuk' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'id_pesanan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'tanggal_masuk' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
        ]);

        // Set the primary key
        $this->forge->addKey('id_barang_masuk', true);

        // Create the table
        $this->forge->createTable('tbl_barang_masuk');
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('tbl_barang_masuk', true);
    }
}
