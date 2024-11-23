<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPenjualan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penjualan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'id_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'total' => [
                'type'    => 'FLOAT',
                'null'    => false,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('id_penjualan', true);

        // Create the table
        $this->forge->createTable('tbl_penjualan');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('tbl_penjualan', true);
    }
}
