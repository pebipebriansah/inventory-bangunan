<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangSupplierModel;
use App\Models\PesananModel;
use CodeIgniter\HTTP\ResponseInterface;

class PesananController extends BaseController
{
    protected $pesananModel;
    protected $barangSupplier;
    protected $barangModel;
    protected $barangMasuk;
    public function __construct() {
        $this->pesananModel = new PesananModel();
        $this->barangSupplier = new BarangSupplierModel();
        $this->barangModel = new \App\Models\BarangModel();
        $this->barangMasuk = new \App\Models\BarangMasukModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Data Pesanan',
            'data_pesanan' => $this->pesananModel->join('tbl_supplier','tbl_supplier.id_supplier = tbl_pesanan.id_supplier')->findAll(),
            'barang_supplier' => $this->barangSupplier->findAll()

        ];
        return view('pages/admin/data-pesanan',$data);
    }
    public function getBarang($id_barang_supplier)
    {
        $barang = $this->barangSupplier->getBarangById($id_barang_supplier);
        if ($barang) {
            echo json_encode($barang); // Mengembalikan data barang dalam format JSON
        } else {
            echo json_encode(['error' => 'Barang tidak ditemukan']);
        }
    }
    public function save(){
        $lastID = $this->pesananModel->getLastID();
        if ($lastID == null) {
            $incrementId = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            // Ambil bagian numerik dari ID
            $sliceId = substr($lastID, 4); // Mengambil karakter setelah "SUP-"
            
            // Pastikan bagian numerik diproses dengan benar
            $incrementId = intval($sliceId) + 1; // Konversi ke integer dan tambahkan 1
        }
        $idPesanan = 'PSN-'.str_pad($incrementId, 3, '0', STR_PAD_LEFT);
        $data = $this->request->getPost();
        $data['id_pesanan'] = $idPesanan;
        $data['status'] = 'Menunggu Konfirmasi';
        if($this->pesananModel->insert($data)){
            session()->setFlashdata('success', 'Data Pesanan berhasil disimpan');
            return redirect()->to('/admin/data-pesanan');
        }
    }
    public function delete($id){
        if($this->pesananModel->delete($id)==true){
            session()->setFlashdata('success', 'Data Pesanan berhasil dihapus');
            return redirect()->to('/admin/data-pesanan');
        }else{
            session()->setFlashdata('error', 'Data Pesanan gagal dihapus');
            return redirect()->to('/admin/data-pesanan');
        }
    }
    public function konfirmasi($id){
        $data = $this->pesananModel->find($id);
        $data['status'] = 'Barang Di Pesan';
        if($this->pesananModel->update($id,$data)){
            session()->setFlashdata('success', 'Pesanan berhasil dikonfirmasi');
            return redirect()->to('/admin/data-pesanan');
        }else{
            session()->setFlashdata('error', 'Pesanan gagal dikonfirmasi');
            return redirect()->to('/admin/data-pesanan');
        }
    }
    public function terima($id){
        $data = $this->pesananModel->find($id);
        $dataBarangSupplier = $this->barangSupplier->find($data['id_barang_supplier']);
        $dataBarangSupplier['stok'] = $dataBarangSupplier['stok'] - $data['jumlah'];
        $this->barangSupplier->update($data['id_barang_supplier'],$dataBarangSupplier);
        $data['status'] = 'Barang Diterima';
        if($this->pesananModel->update($id,$data)){
            session()->setFlashdata('success', 'Pesanan berhasil diterima');
            return redirect()->to('/admin/data-pesanan');
        }else{
            session()->setFlashdata('error', 'Pesanan gagal diterima');
            return redirect()->to('/admin/data-pesanan');
        }
    }
    public function masuk($id){
        // Generate ID barang
        $lastID = $this->barangModel->getLastID();
        if ($lastID == null) {
            $incrementId = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            // Ambil bagian numerik dari ID
            $sliceId = substr($lastID, 4); // Mengambil karakter setelah "SUP-"
            
            // Pastikan bagian numerik diproses dengan benar
            $incrementId = intval($sliceId) + 1; // Konversi ke integer dan tambahkan 1
        }
        $idBarang = 'BRG-'.str_pad($incrementId, 3, '0', STR_PAD_LEFT);

        // Generate ID Barang Masuk
        $lastIDMasuk = $this->barangMasuk->getLastID();
        if ($lastIDMasuk == null) {
            $incrementIdMasuk = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            // Ambil bagian numerik dari ID
            $sliceIdMasuk = substr($lastIDMasuk, 4); // Mengambil karakter setelah "SUP-"
            
            // Pastikan bagian numerik diproses dengan benar
            $incrementIdMasuk = intval($sliceIdMasuk) + 1; // Konversi ke integer dan tambahkan 1
        }
        $idBarangMasuk = 'BRGM-'.str_pad($incrementIdMasuk, 3, '0', STR_PAD_LEFT);
        
        $data = $this->pesananModel->find($id);
        $dataBarang = $this->barangModel
            ->where('nama_barang', $data['nama_barang'])
            ->where('id_supplier', $data['id_supplier'])
            ->first(); // Mengambil satu baris data yang sesuai
        if($dataBarang == true){
            $dataBarang['stok'] = $dataBarang['stok'] + $data['jumlah'];
            $this->barangModel->where('nama_barang', $data['nama_barang'])->where('id_supplier', $data['id_supplier'])->set($dataBarang)->update($dataBarang);
        }else{
            $dataBarang = [
                'id_barang' => $idBarang,
                'nama_barang' => $data['nama_barang'],
                'id_supplier' => $data['id_supplier'],
                'harga' => $data['harga'],
                'stok' => $data['jumlah']
            ];
            $this->barangModel->insert($dataBarang);
        }
        $dataBarangMasuk = [
            'id_barang_masuk' => $idBarangMasuk,
            'id_pesanan' => $data['id_pesanan'],
            'tanggal_masuk' => date('Y-m-d / H:i:s'),
        ];
        $this->barangMasuk->insert($dataBarangMasuk);
        $data['status'] = 'Ke Barang Masuk';
        if($this->pesananModel->update($id,$data)){
            session()->setFlashdata('success', 'Pesanan berhasil dimasukkan');
            return redirect()->to('/admin/data-pesanan');
        }else{
            session()->setFlashdata('error', 'Pesanan gagal dimasukkan');
            return redirect()->to('/admin/data-pesanan');
        }
    }
}