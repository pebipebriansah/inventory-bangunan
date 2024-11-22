    <?=$this->extend('layout/layout-admin')?>
    <?=$this->section('content')?>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-8 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-8">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Congratulations <?=session()->get('nama_lengkap');?></h5>
                                <p class="mb-4">
                                    Anda Berhasil masuk menjadi <?=session()->get('role');?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <?=$this->endSection()?>