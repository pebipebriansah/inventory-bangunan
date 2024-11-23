<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'null'       => false,
            ],
            'nama_lengkap' => [
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
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'manager', 'gudang'],
                'null'       => false,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('id_user', true);

        // Create the table
        $this->forge->createTable('tbl_user');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('tbl_user', true);
    }
}
