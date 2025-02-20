<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangSupplierModel extends Model
{
    protected $table            = 'tbl_barang_supplier';
    protected $primaryKey       = 'id_barang_supplier';
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
        $builder = $this->db->table('tbl_barang_supplier');
        $builder->select('id_barang_supplier');
        $builder->orderBy('id_barang_supplier', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->id_barang_supplier;
        } else {
            return null;
        }
    }
    public function getBarangById($id_barang_supplier)
    {
        return $this->where('id_barang_supplier', $id_barang_supplier)->first();
    }
}
