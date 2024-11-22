<?=$this->extend('layout/layout-admin')?>
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
        <!-- Search and Filter Section -->
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data Penjualan</span>
            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                data-bs-target="#addOrderModal">
                Tambah Penjualan
            </button>
        </h5>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6 col-sm-12 mb-2 mb-md-0">
                    <input type="text" id="search-input" class="form-control" placeholder="Search...">
                </div>
                <div class="col-md-6 col-sm-12 text-md-end text-sm-start">
                    <button id="print-button" class="btn btn-primary me-2">Print</button>
                    <button id="download-button" class="btn btn-success">Download</button>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Penjualan</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (empty($penjualan)): ?>
                    <tr>
                        <td colspan="7" class="text-center">No data available</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($penjualan as $pj) :?>
                    <tr>
                        <td><?=$pj['id_penjualan'];?></td>
                        <td><?=$pj['nama_barang'];?></td>
                        <td><?=$pj['qty'];?></td>
                        <td><?=$pj['total']?></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-id="<?=$pj['id_penjualan']?>"
                                        data-user='<?= json_encode($pj) ?>' onclick="setEditModalData(this)">
                                        <i class="bx bx-edit-alt me-2"></i> Edit
                                    </a>

                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-id="<?=$pj['id_penjualan']?>"
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
    <?php foreach ($penjualan as $pj) :?>
    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                    <form id="deleteForm" method="POST"
                        action="<?=base_url('admin/data-penjualan/delete/').$pj['id_penjualan']?>">
                        <input type="hidden" id="deleteBarangId" name="barang_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach;?>
    <!-- Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addOrderForm" method="POST" action="<?=base_url('admin/data-penjualan/save')?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                <select name="id_barang" id="id_barang" class="form-control">
                                    <?php foreach($barang as $br) : ?>
                                    <option value="#">Silahkan Pilih</option>
                                    <option value="<?=$br['id_barang']?>"><?=$br['nama_barang']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label class="form-label">Qty</label>
                                <input type="text" name="qty" id="qty" class="form-control" placeholder="Enter Stok" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Harga</label>
                                <input type="text" name="harga" id="harga" class="form-control"
                                    placeholder="Contoh 150.000" readonly />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Total</label>
                                <input type="text" name="total" id="total" class="form-control"
                                    placeholder="Contoh 150.000" readonly />
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
        const userId = button.getAttribute('data-id');

        // Ambil data lainnya dari atribut data-user (dalam JSON)
        const userData = JSON.parse(button.getAttribute('data-user'));

        // Isi field pada modal dengan data
        document.querySelector('#editModal #idUser').value = userId; // dari data-id
        document.querySelector('#editModal #namaLengkap').value = userData.nama_lengkap;
        document.querySelector('#editModal #username').value = userData.username;
        document.querySelector('#editModal #password').value = userData.password;
        document.querySelector('#editModal #role').value = userData.role;
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
    <script>
    $(document).ready(function() {
        $('#id_barang').change(function() {
            const selectedId = $(this).val();
            if (selectedId) {
                // Lakukan permintaan AJAX ke controller
                $.ajax({
                    url: `<?=base_url('get-barang-penjualan/');?>${selectedId}`, // Gunakan backticks dengan interpolasi
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.nama_barang && data.id_supplier && data.harga) {
                            $('#nama_barang').val(data.nama_barang);
                            $('#id_supplier').val(data.id_supplier);
                            $('#harga').val(data.harga);
                            $('#total').val('');
                        } else {
                            alert('Data tidak lengkap.');
                        }
                    },
                    error: function() {
                        alert('Gagal mengambil data barang.');
                    }
                });
            } else {
                // Kosongkan semua input jika tidak ada barang yang dipilih
                $('#nama_barang').val('');
                $('#harga').val('');
                $('#total').val('');
            }
        });

        // Hitung total saat jumlah diinputkan
        $('#qty').on('input', function() {
            const jumlah = parseInt($(this).val()) || 0;
            const harga = parseInt($('#harga').val()) || 0;
            const total = jumlah * harga;
            $('#total').val(total);
        });
    });
    </script>
    <?=$this->endSection()?>