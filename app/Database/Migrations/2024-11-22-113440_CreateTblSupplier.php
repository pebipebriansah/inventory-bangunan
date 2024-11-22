<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblSupplier extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_supplier' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'nama_supplier' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('id_supplier', true);

        // Create the table
        $this->forge->createTable('tbl_supplier');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('tbl_supplier', true);
    }
}
