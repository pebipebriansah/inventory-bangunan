<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblBarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang' => [
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

        // Set the primary key
        $this->forge->addKey('id_barang', true);

        // Create the table
        $this->forge->createTable('tbl_barang');
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('tbl_barang', true);
    }
}
