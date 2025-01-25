<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'tbl_barang';
    protected $primaryKey       = 'id_barang';
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
        $builder = $this->db->table('tbl_barang');
        $builder->select('id_barang');
        $builder->orderBy('id_barang', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->id_barang;
        } else {
            return null;
        }
    }
    public function getBarangById($id_barang)
    {
        return $this->where('id_barang', $id_barang)->first();
    }
    public function getBarangQuery() {
        return $this->builder()
            ->join('tbl_supplier', 'tbl_supplier.id_supplier = tbl_barang.id_supplier')
            ->select('tbl_barang.id_barang, tbl_barang.nama_barang, tbl_barang.harga, tbl_supplier.nama_supplier');
    }
    public function getStokHampirHabis() {
        $stokMinimum = 50; // Stok minimum yang ditetapkan dalam program
        return $this->builder()
            ->where('stok <=', $stokMinimum)
            ->select('nama_barang, stok')
            ->get()
            ->getResultArray();
    }  
}
