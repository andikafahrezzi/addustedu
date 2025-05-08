
    <!-- Registration Form Area -->
    <div class="container mt-5 mb-5" id="registration">
        <div class="row bg-registration p-3">
            <div class="col-md-12 text-center">
                <p class="registration-title font-weight-bold display-4 mt-4" style="font-size: 50px;">
                    Pendaftaran addustedu</p>
                <p style="line-height:-30px;margin-top:-20px;">Silahkan isi data data yangg diperlukan dibawah ini </p>
                <hr>
            </div>
            <div class="col-md-6 mx-auto text-center">
                <div class="bodymovin" data-icon="<?= base_url('assets/') ?>json/registration-animation.json"></div>
            </div>
            <div class="col-md-6 mx-auto my-auto mt--5">
                <form action="<?= base_url('admin/add_siswa') ?>" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="form-group">
                        <label for="nis" class="label-font-register">nis</label>
                        <input type="number" class="form-control" name="nis" id="nis" value="<?= set_value('nis'); ?>">
                        <?= form_error('nis', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap" class="label-font-register">Nama lengkap</label>
                        <input type="text" autocomplete="off" class="form-control effect-9" name="nama" id="nama_lengkap" value="<?= set_value('nama'); ?>">
                        <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="email" class="label-font-register">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email'); ?>">
                        <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password" class="label-font-register">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="retype_password" class="label-font-register">Retype password</label>
                            <input type="password" class="form-control" name="retype_password" id="retype_password">
                            <?= form_error('retype_password', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input checkbox" type="checkbox" id="defaultCheck1" onchange="document.getElementById('btnsubmit').disabled = !this.checked;">
                        <label class=" form-check-label" for="defaultCheck1">
                            Saya setuju dan ingin melanjutkan
                        </label>
                    </div>
                    <p class="terms">Dengan mendaftar anda menyetujui <i>privasi dan persyaratan ketentuan
                            hukum kami </i>
                        baca selengkapnya <a href="#"> disini</a></p>
                    <button type="submit" name="submit" id="btnsubmit" disabled class="btn btn-block btn-modal btn-submit">Daftar
                        Sekarang!</button>
                </form>
            </div>
        </div>
    </div>
    <!-- End Registration Form Area -->

    <!-- Start Checkbox Scripts -->
    <script>
        $('.tab1_btn').prop('disabled', !$('.tab1_chk:checked')
            .length);
        $('input[type=checkbox]').click(function() {
            if ($('.tab1_chk:checkbox:checked').length > 0) {
                $('.btn-submit').prop('disabled', false);
            } else {
                $('.btn-submit').prop('disabled', true);
            }
        });
    </script>
    <!-- End Checkbox Scripts -->