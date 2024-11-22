<?=$this->extend('layout/layout-supplier')?>
<?=$this->section('content')?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <?php if (session()->getFlashdata('success')) :?>
    <div class="bs-toast toast fade show bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Success</div>
            <small id="toast-timestamp"><?= date('H:i:s'); ?></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?= session()->getFlashdata('success');?></div>
    </div>
    <?php endif;?>
    <?php if (session()->getFlashdata('error')) :?>
    <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Error</div>
            <small id="toast-timestamp"><?= date('H:i:s'); ?></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?= session()->getFlashdata('error');?></div>
    </div>
    <?php endif;?>
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data Pesanan</span>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (empty($data_pesanan)): ?>
                    <tr>
                        <td colspan="7" class="text-center">No data available</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($data_pesanan as $pesanan) :?>
                    <tr>
                        <td><?=$pesanan['id_pesanan'];?></td>
                        <td><?=$pesanan['nama_barang'];?></td>
                        <td><?=$pesanan['jumlah'];?></td>
                        <td><?=$pesanan['harga']?></td>
                        <td><?=$pesanan['total']?></td>
                        <td><?=$pesanan['nama_supplier'];?></td>
                        <td><?=$pesanan['status']?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <?php if ($pesanan['status'] == 'Barang Di Pesan'): ?>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#kirimModal<?=$pesanan['id_pesanan']?>" data-id="<?=$pesanan['id_pesanan']?>"
                                        onclick="setKirimModalData(this)"><i class="bx bx-send me-2"></i>
                                        Kirim Barang</a
                                    <?php endif;?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Kirim Modal -->
    <?php foreach ($data_pesanan as $pesanan) :?>
    <div class="modal fade" id="kirimModal<?=$pesanan['id_pesanan']?>" tabindex="-1" aria-labelledby="kirimModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kirimModalLabel">Konfirmasi Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Mengirim Barang Ini ?</p>
                </div>
                <div class="modal-footer">
                    <form id="confirmForm" method="POST"
                        action="<?=base_url('supplier/data-pesanan/kirim/').$pesanan['id_pesanan']?>">
                        <input type="hidden" id="kirimId" name="kirim_id">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Kirim Barang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach;?>
    <!-- / Content -->
    <?=$this->endSection()?>
    <?=$this->section('script')?>
    <script>
    // Function to set data for Delete Modal
    function setKirimModalData(button) {
        const userId = button.getAttribute('data-id');
        document.getElementById('kirimId').value = userId;
    }
    </script>
    <script>
    // Menutup toast setelah 2 detik
    setTimeout(function() {
        let toastElement = document.querySelector('.toast');
        let toast = new bootstrap.Toast(toastElement);
        toast.hide(); // Menyembunyikan toast
    }, 2000); // 2 detik
    </script>
    <?=$this->endSection()?>