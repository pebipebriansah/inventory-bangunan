<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?=base_url('assets/');?>"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Register Toko Bangunan</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="<?=base_url('assets/img/favicon/favicon.ico');?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/fonts/boxicons.css');?>" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/css/core.css');?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/css/theme-default.css');?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/demo.css');?>" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css');?>" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/css/pages/page-auth.css');?>" />
    <script src="<?=base_url('assets/vendor/js/helpers.js');?>"></script>
    <script src="<?=base_url('assets/js/config.js');?>"></script>
  </head>
  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <img src="<?=base_url('image/tb.png');?>" alt="Sneat" width="50" height="50" />
                  <span class="app-brand-text text-uppercase text-black">TB Wawan</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2 text-center">Daftar</h4>
              <form id="formAuthentication" class="mb-3" action="<?=base_url('register/save')?>" method="POST">
                <div class="mb-3">
                  <label for="username" class="form-label">Nama Lengkap</label>
                  <input
                    type="text"
                    class="form-control"
                    id="nama"
                    name="nama_lengkap"
                    placeholder="Enter your nama"
                    autofocus
                  />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter your Username" />
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Sign up</button>
              </form>
              <p class="text-center">
                <span>Already have an account?</span>
                <a href="<?=base_url('/');?>">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?=base_url('assets/vendor/libs/jquery/jquery.js');?>"></script>
    <script src="<?=base_url('assets/vendor/libs/popper/popper.js');?>"></script>
    <script src="<?=base_url('assets/vendor/js/bootstrap.js');?>"></script>
    <script src="<?=base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js');?>"></script>
    <script src="<?=base_url('assets/vendor/js/menu.js');?>"></script>
    <script src="<?=base_url('assets/js/main.js');?>"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
