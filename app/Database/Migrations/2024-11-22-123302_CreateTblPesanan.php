<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPesanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pesanan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
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
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'harga' => [
                'type'    => 'FLOAT',
                'null'    => false,
            ],
            'total' => [
                'type'    => 'FLOAT',
                'null'    => false,
            ],
            'id_supplier' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'Menunggu Konfirmasi',
                    'Barang Di Pesan',
                    'Barang Di Kirim',
                    'Barang Diterima',
                    'Ke barang Masuk',
                ],
                'null'       => false,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('id_pesanan', true);

        // Create the table
        $this->forge->createTable('tbl_pesanan');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('tbl_pesanan', true);
    }
}
