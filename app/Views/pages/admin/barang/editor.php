<div class="modal fade" id="editor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editor-form" method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editor-label">Edit Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="idUser" class="form-label">ID Barang</label>
                            <input type="text" id="idBarang" name="id_barang" class="form-control" readonly />
                        </div>
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Barang</label>
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
                        <div class="mb-3">
                            <label for="role" class="form-label">Supplier</label>
                            <?php foreach ($data_supplier as $supplier) :?>
                            <select id="id_supplier" name="id_supplier" class="form-control">
                                <option value="<?=$supplier['id_supplier']?>"><?=$supplier['nama_supplier']?></option>
                            </select>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>