<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="<?=base_url('assets/')?>;" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login Toko Bangunan</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/fonts/boxicons.css');?>" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/css/core.css');?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/css/theme-default.css');?>"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/demo.css');?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css');?>" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/css/pages/page-auth.css');?>" />
    <script src="<?=base_url('assets/vendor/js/helpers.js');?>"></script>
    <script src="<?=base_url('assets/js/config.js');?>"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')) :?>
                        <div class="bs-toast toast fade show bg-primary" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="toast-body">
                                <?= session()->getFlashdata('success');?></div>
                        </div>
                        <?php endif;?>
                        <?php if (session()->getFlashdata('error')) :?>
                        <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="toast-body">
                                <?= session()->getFlashdata('error');?></div>
                        </div>
                        <?php endif;?>
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2">
                                <img src="<?=base_url('image/tb.png');?>" alt="Sneat" width="50" height="50" />
                                <span class="app-brand-text text-uppercase text-black">TB Wawan</span>
                            </a>
                        </div>
                        <form id="formAuthentication" class="mb-3" action="<?=base_url('auth');?>" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Username</label>
                                <input type="text" class="form-control" id="email" name="username"
                                    placeholder="Enter your username" autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="<?=base_url('register');?>">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
    // Menutup toast setelah 2 detik
    setTimeout(function() {
        let toastElement = document.querySelector('.toast');
        let toast = new bootstrap.Toast(toastElement);
        toast.hide(); // Menyembunyikan toast
    }, 2000); // 2 detik
    </script>
</body>

</html>