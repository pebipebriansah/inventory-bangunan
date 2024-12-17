<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $table            = 'tbl_barang_keluar';
    protected $primaryKey       = 'id_barang_keluar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = true;

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    public function getLastID(){
        $builder = $this->db->table('tbl_barang_keluar');
        $builder->select('id_barang_keluar');
        $builder->orderBy('id_barang_keluar', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->id_barang_keluar;
        } else {
            return null;
        }
    }
    public function getBarangKeluarQuery() {
        return $this->builder('tbl_barang_keluar') // Builder untuk tabel barang_keluar
            ->join('tbl_penjualan', 'tbl_penjualan.id_penjualan = tbl_barang_keluar.id_penjualan') // Bergabung dengan tabel tbl_penjualan
            ->join('tbl_barang', 'tbl_barang.id_barang = tbl_penjualan.id_barang') // Bergabung dengan tabel tbl_barang
            ->select('tbl_barang_keluar.id_barang_keluar, tbl_barang.nama_barang, tbl_penjualan.qty, tbl_penjualan.total, tbl_barang_keluar.tanggal_keluar') // Kolom yang akan dipilih
            ->orderBy('tbl_barang_keluar.tanggal_keluar', 'ASC'); // Mengurutkan berdasarkan tanggal_keluar
    }    
}
