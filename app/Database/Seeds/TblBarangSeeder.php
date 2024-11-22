<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class TblBarangSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // Prepare data
        $data = [];
        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'id_barang'   => 'BRG-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nama_barang' => $faker->words(3, true), // Generate a random 3-word name
                'stok'        => $faker->numberBetween(10, 100), // Random stock between 10 and 100
                'harga'       => $faker->numberBetween(10000, 100000), // Random price between 10,000 and 100,000
                'id_supplier' => 'SUP-' . str_pad($faker->numberBetween(1, 3), 3, '0', STR_PAD_LEFT),
            ];
        }

        // Insert data into the database
        $this->db->table('tbl_barang')->insertBatch($data);
    }
}
