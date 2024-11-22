<?=$this->extend('layout/layout-supplier')?>
<?=$this->section('content')?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <?php if (session()->getFlashdata('success')) :?>
    <div class="bs-toast toast fade show bg-success" role="alert" aria-live="assertive" aria-atomic="true">
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
            <span>Data Barang</span>
            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                data-bs-target="#addOrderModal">
                Tambah Barang
            </button>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (empty($data_barang)): ?>
                    <tr>
                        <td colspan="7" class="text-center">No data available</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($data_barang as $barang) :?>
                    <tr>
                        <td><?=$barang['id_barang_supplier'];?></td>
                        <td><?=$barang['nama_barang'];?></td>
                        <td><?=$barang['stok'];?></td>
                        <td><?=$barang['harga']?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?=$barang['id_barang_supplier']?>"
                                        data-id="<?=$barang['id_barang_supplier']?>"
                                        data-user='<?= json_encode($barang) ?>' onclick="setEditModalData(this)">
                                        <i class="bx bx-edit-alt me-2"></i> Edit
                                    </a>

                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?=$barang['id_barang_supplier']?>"
                                        data-id="<?=$barang['id_barang_supplier']?>"
                                        onclick="setDeleteModalData(this)"><i class="bx bx-trash me-2"></i>
                                        Delete</a>
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
    <?php if (!empty($data_barang)) : ?>
    <?php foreach ($data_barang as $barang) :?>
    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal<?=$barang['id_barang_supplier'];?>" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Barang?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="post"
                        action="<?=base_url('supplier/data-barang/delete/').$barang['id_barang_supplier'];?>">
                        <input type="hidden" id="deleteBarangId" name="barang_supplier_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal<?=$barang['id_barang_supplier']?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editForm" method="POST"
                    action="<?=base_url('supplier/data-barang/update/').$barang['id_barang_supplier']?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Edit Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="idBarang" class="form-label">ID Barang</label>
                            <input type="text" id="idBarangSupplier" name="id_barang_supplier" class="form-control"
                                readonly />
                        </div>
                        <div class="mb-3">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" id="namaBarang" name="nama_barang" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Stok</label>
                            <input type="text" id="stok" name="stok" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Harga</label>
                            <input type="text" id="harga" name="harga" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach;?>
    <?php else : ?>
    <?php endif; ?>
    <!-- Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addOrderForm" method="POST" action="<?=base_url('supplier/data-barang/save')?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">ID Barang</label>
                                <input type="text" name="id_barang_supplier" readonly value="<?=$lastId?>"
                                    class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label class="form-label">Stok</label>
                                <input type="text" name="stok" class="form-control" placeholder="Enter Stok" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Harga</label>
                                <input type="text" name="harga" id="dobWithTitle" class="form-control"
                                    placeholder="Contoh 150.000" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- / Content -->
    <?=$this->endSection()?>
    <?=$this->section('script')?>
    <script>
    // Function to set data for Delete Modal
    function setDeleteModalData(button) {
        const barangId = button.getAttribute('data-id');
        document.getElementById('deleteBarangId').value = barangId;
    }

    function setEditModalData(button) {
        // Ambil data ID dari atribut data-id
        const barangId = button.getAttribute('data-id');
        // Ambil data lainnya dari atribut data-user (dalam JSON)
        const barangData = JSON.parse(button.getAttribute('data-user'));


        // Isi field pada modal dengan data
        document.querySelector(`#editModal${barangId} #idBarangSupplier`).value = barangId; // dari data-id
        document.querySelector(`#editModal${barangId} #namaBarang`).value = barangData.nama_barang;
        document.querySelector(`#editModal${barangId} #stok`).value = barangData.stok;
        document.querySelector(`#editModal${barangId} #harga`).value = barangData.harga;
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