<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table            = 'tbl_barang_masuk';
    protected $primaryKey       = 'id_barang_masuk';
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
        $builder = $this->db->table('tbl_barang_masuk');
        $builder->select('id_barang_masuk');
        $builder->orderBy('id_barang_masuk', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->id_barang_masuk;
        } else {
            return null;
        }
    }
    public function getBarangMasukQuery() {
        return $this->builder('tbl_barang_masuk') // Builder untuk tabel barang_masuk
            ->join('tbl_pesanan', 'tbl_barang_masuk.id_pesanan = tbl_pesanan.id_pesanan') // Bergabung dengan tabel tbl_pesanan
            ->join('tbl_supplier', 'tbl_pesanan.id_supplier = tbl_supplier.id_supplier') // Bergabung dengan tabel tbl_supplier
            ->join('tbl_barang', 'tbl_barang_masuk.id_barang = tbl_barang.id_barang')
            ->select('tbl_barang_masuk.id_barang_masuk, tbl_barang.nama_barang, tbl_pesanan.total, tbl_barang_masuk.stok,  tbl_supplier.nama_supplier, tbl_barang_masuk.tanggal_masuk') // Kolom yang akan dipilih
            ->orderBy('tbl_barang_masuk.tanggal_masuk', 'ASC'); // Mengurutkan berdasarkan tanggal_masuk
    }
}
