
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="">
                        <div class="card" style="width:100%;">
                            <div class="card-body">
                                <h2 class="card-title" style="color: black;">Update Data Guru</h2>
                                <hr>
                                <p class="card-text"> Update data siswa meliputi Email dan Nama Lengkap.
                                    Kita tidak bisa mengubah password guru, Hanya guru yang dapat mengubah passwordnya
                                    sendiri.
                                </p>
                                <a href="#detail" class="btn btn-success">Saya paham dan
                                    ingin melanjutkan ⭢</a>
                            </div>
                        </div>
                    </div>
                    <div class="card card-success">
                        <div class="col-md-12 text-center">
                            <p class="registration-title font-weight-bold display-4 mt-4" style="color:black; font-size: 50px;">
                                Update Data Guru</p>
                            <p style="line-height:-30px;margin-top:-20px;">Silahkan isi data data yang diperlukan
                                dibawah </p>
                            <hr>
                        </div>
                        <?php if ($this->session->flashdata('error-edit')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('error-edit'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('success-edit')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success-edit'); ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="<?= base_url('admin/guru_edit') ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                        <input type="hidden" name="nip" value="<?= $user->nip ?>">
                        <div class="form-group">
                            <label for="nuptk">Nomor Unik Pendidik dan Tenaga Kependidikan</label>
                            <input id="nuptk" type="text" class="form-control" value="<?= $user->nuptk ?>" name="nuptk">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" value="<?= $user->email ?>" class="form-control" name="email">
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input id="nama" type="text" value="<?= $user->nama_guru ?>" class="form-control" name="nama">
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                        <input type="password" name="nPassword" class="form-control" placeholder="Password Baru">
                            <label>Re-type Password Baru</label>
                        <input type="password" name="nRPassword" class="form-control" placeholder="Ulangi Password Baru">
                        </div>

                        <div class="form-group">
                            <label>Mata Pelajaran yang Diajar</label><br>
                            <?php foreach ($mapel as $m): ?>
                                <?php $isChecked = in_array($m->id, $mapel_selected) ? 'checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="mapel[]" id="mapel<?= $m->id ?>" 
                                        value="<?= $m->id ?>" <?= $isChecked ?>>
                                    <label class="form-check-label" for="mapel<?= $m->id ?>"><?= $m->nama_mapel ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg btn-block">
                                Update data ⭢
                            </button>
                        </div>
                    </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- End Main Content -->


    <!-- General JS Scripts -->
    <script>
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <!-- Template JS File -->
    