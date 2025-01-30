<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table            = 'tbl_penjualan';
    protected $primaryKey       = 'id_penjualan';
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
        $builder = $this->db->table('tbl_penjualan');
        $builder->select('id_penjualan');
        $builder->orderBy('id_penjualan', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->id_penjualan;
        } else {
            return null;
        }
    }
    public function getSalesData()
    {
        return $this->db->table('tbl_penjualan')
        ->join('tbl_barang', 'tbl_penjualan.id_barang = tbl_barang.id_barang')
                        ->select('tbl_barang.nama_barang, SUM(tbl_penjualan.qty) as total_sold')
                        ->groupBy('tbl_barang.nama_barang')
                        ->orderBy('total_sold', 'DESC')
                        ->get()
                        ->getResultArray();
    }
    public function getTotalPenjualan($id_barang)
    {
        $builder = $this->db->table($this->table);
        $builder->selectSum('qty', 'total_qty'); // Menggunakan alias untuk kejelasan
        $builder->where('id_barang', $id_barang);
        $query = $builder->get();

        $row = $query->getRow();
        return $row && isset($row->total_qty) ? (int)$row->total_qty : 0;
    }
    public function getTotalPenjualanByMonth($id_barang, $month, $year)
    {
        return $this->where('id_barang', $id_barang)
                    ->where('MONTH(tanggal_penjualan)', $month)
                    ->where('YEAR(tanggal_penjualan)', $year)
                    ->selectSum('qty')  // Menjumlahkan jumlah barang yang terjual
                    ->first()['qty'] ?? 0; // Mengambil nilai qty atau 0 jika tidak ada penjualan
    }
    public function getPenjualanQuery() {
        return $this->builder()
            ->join('tbl_barang', 'tbl_barang.id_barang = tbl_penjualan.id_barang')
            ->select('tbl_penjualan.id_penjualan, tbl_barang.nama_barang, tbl_barang.harga, tbl_penjualan.qty, tbl_penjualan.total');
    }  
    public function getPenjualanTerbanyak()
    {
        return $this->select('tbl_barang.nama_barang, SUM(tbl_penjualan.qty) as stok_terjual')
                    ->join('tbl_barang', 'tbl_barang.id_barang = tbl_penjualan.id_barang')
                    ->groupBy('tbl_penjualan.id_barang')
                    ->orderBy('stok_terjual', 'DESC')
                    ->findAll();
    } 
}