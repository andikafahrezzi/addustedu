
    <!-- Main Content -->
    <div id="app">
        <section class="section">
            <div class="d-flex flex-wrap align-items-stretch">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="p-4 m-3">
                        <a href="<?=base_url('welcome')?>"> <img src="<?=base_url('assets/')?>/img/logou.png" alt="logo"
                                width="150" class=" mb-5 mt-2"></a>
                        <h4 class="text-dark font-weight-normal">Selamat datang di <span
                                class="font-weight-bold">addustedu</span>
                        </h4>
                        <p class="text-muted">Sebelum masuk ke halaman admin, anda harus login terlebih dahulu sebagai
                            admin. silahkan isi data dibawah untuk melanjutkan.</p>
                        <form method="post" action="<?=base_url('welcome/admin')?>" class="needs-validation"
                            novalidate="">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" tabindex="1" required
                                    autofocus>
                                <div class="invalid-feedback">
                                    Harap isi bidang email
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" tabindex="2"
                                    required>
                                <div class="invalid-feedback">
                                    Harap isi bidang password
                                </div>
                            </div>
                            <br>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-block btn-success btn-lg btn-icon icon-right"
                                    tabindex="4">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
                    data-background="<?=base_url('assets/')?>stisla-assets/img/unsplash/login-bg.jpg">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-5 pb-3">
                                <h1 class="mb-2 display-4 font-weight-bold text-white">Selamat datang!</h1>
                                <h5 class="font-weight-normal text-muted-transparent text-white">Silahkan login untuk
                                    masuk ke
                                    halaman admin.</h5>
                            </div>
                            Made with <span class="text-danger"> &#10084;</span> by <a class="text-light bb"
                                target="_blank" href="https://syauqizaidan.github.io/">Syaauqi Zaaidan</a> - Image by <a
                                class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- End Main Content -->

    <!-- Sweetalert Flashdata -->

    <?php if ($this->session->flashdata('success-reg')): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Kamu berhasil daftar!',
        text: 'Silahkan Cek Email Kamu, Buat Verifikasi!',
        showConfirmButton: false,
        timer: 2500
    })
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('login-success')): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Kamu berhasil daftar!',
        text: 'Sekarang login yuk!',
        showConfirmButton: false,
        timer: 2500
    })
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('success-verify')): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Email Telah Diverifikasi!',
        text: 'Sekarang login yuk!',
        showConfirmButton: false,
        timer: 2500
    })
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('success-logout')): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Kamu berhasil logout!',
        text: 'Selamat tinggal, Sampai jumpa lagi!',
        showConfirmButton: false,
        timer: 2500
    })
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('fail-login')): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal login!',
        text: 'Silahkan Periksa Kembali Email dan Password Kamu!',
        showConfirmButton: false,
        timer: 2500
    });
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('fail-email')): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Email Belum Diverifikasi!',
        text: 'Silahkan Cek Email Kamu Dahulu!',
        showConfirmButton: false,
        timer: 2500
    })
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('fail-pass')): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Password Salah!',
        text: 'Silahkan Periksa Kembali Password Kamu!',
        showConfirmButton: false,
        timer: 2500
    });
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('not-login')): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Harap Login Terlebih Dahulu !',
        text: 'Silahkan Login Dahulu !',
        showConfirmButton: false,
        timer: 2500
    });
    </script>
    <?php endif;?>
    <!-- end sweetalert -->


    <!-- Page Specific JS File -->
