<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblBarangSupplier extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang_supplier' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'nama_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'stok' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'harga' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'id_supplier' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('id_barang_supplier', true);

        // Create the table
        $this->forge->createTable('tbl_barang_supplier');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('tbl_barang_supplier', true);
    }
}
