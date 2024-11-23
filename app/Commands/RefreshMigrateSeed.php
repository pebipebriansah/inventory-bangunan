<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class RefreshMigrateSeed extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:refresh-seed';
    protected $description = 'Refresh migrations and run seeders.';

    public function run(array $params)
    {
        // Run migrate:refresh
        CLI::write('Refreshing migrations...', 'yellow');
        $this->call('migrate:refresh');

        // Run db:seed
        CLI::write('Seeding database...', 'yellow');
        $this->call('db:seed', ['name' => 'TblUserSeeder']);
        $this->call('db:seed', ['name' => 'TblBarangSeeder']);
        $this->call('db:seed', ['name' => 'TblSupplierSeeder']);
        $this->call('db:seed', ['name' => 'TblBarangMasukSeeder']);
        $this->call('db:seed', ['name' => 'TblBarangSupplierSeeder']);
    }
}
