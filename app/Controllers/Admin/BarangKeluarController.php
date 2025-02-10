<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangModel;
use App\Models\BarangMasukModel;

class BarangKeluarController extends BaseController
{
    protected $barangKeluar;
    protected $barang;
    protected $barangMasuk;
    protected $pageUtama;
    public function __construct() {
        $this->barangKeluar = new BarangKeluarModel();
        $this->barang = new BarangModel();
        $this->barangMasuk = new BarangMasukModel();
        $this->pageUtama = 'pages/admin/barang-keluar/data-barang-keluar';
    }
        public function index()
    {
        $data = [
            'title' => 'Data Barang Keluar',
            'barang' => $this->barang->findAll(),
        ];

        return view($this->pageUtama, $data);
    }
    public function getBarangKeluar() {
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $data = $this->barangKeluar->getBarangKeluarQuery();
        if ($startDate && $endDate) {
            $data->where('tbl_barang_keluar.tanggal_keluar >=', $startDate)
                ->where('tbl_barang_keluar.tanggal_keluar <=', $endDate);
        }
        return DataTable::of($data)
            ->addNumbering()
            ->toJson();
    }

    public function save()
    {
        $data = $this->request->getPost();
        // Generate Barang Keluar ID
        $lastIDKeluar = $this->barangKeluar->getLastID();
        $incrementIdKeluar = ($lastIDKeluar == null) ? 1 : intval(substr($lastIDKeluar, 5)) + 1;
        $idKeluar = 'BRGK-' . str_pad($incrementIdKeluar, 3, '0', STR_PAD_LEFT);

        // Jumlah barang yang akan dijual
        $qtyKeluar = $data['jumlah'];
        $idBarang = $data['id_barang'];

        // Ambil stok barang masuk berdasarkan FIFO
        $stokBarangMasuk = $this->barangMasuk
            ->where('id_barang', $idBarang)
            ->where('stok >', 0)
            ->orderBy('tanggal_masuk', 'ASC')
            ->findAll();

        $totalStokTersedia = array_sum(array_column($stokBarangMasuk, 'stok'));
        if ($qtyKeluar > $totalStokTersedia) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Stok tidak mencukupi untuk penjualan.'
            ]);
        }

        foreach ($stokBarangMasuk as $batch) {
            if ($qtyKeluar <= 0) break;

            if ($batch['stok'] >= $qtyKeluar) {
                $this->barangMasuk->update($batch['id_barang_masuk'], [
                    'stok' => $batch['stok'] - $qtyKeluar
                ]);
                $qtyKeluar = 0;
            } else {
                $qtyKeluar -= $batch['stok'];
                $this->barangMasuk->update($batch['id_barang_masuk'], ['stok' => 0]);
            }
        }

        // Simpan data barang keluar
        $dataBarangKeluar = [
            'id_barang_keluar' => $idKeluar,
            'id_barang_masuk' => $stokBarangMasuk['id_barang_masuk'],
            'jumlah' => $qtyKeluar,
            'tanggal_keluar' => date('Y-m-d'),
        ];
        if ($this->barangKeluar->insert($$dataBarangKeluar) !== false) {
            // Buat pesan FIFO
            $fifoMessage = "Barang keluar berhasil menggunakan FIFO dengan batch:\n";
            foreach ($stokBarangMasuk as $batch) {
                if ($batch['stok'] > 0) {
                    $fifoMessage .= "- Batch ID: {$batch['id_barang_masuk']}, Tanggal Pemesanan: {$batch['tanggal_masuk']}, Sisa Stok: {$batch['stok']}.\n";
                }
            }
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Penjualan berhasil disimpan. ' . $fifoMessage
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Penjualan gagal disimpan'
            ]);
        }
        
    }
}