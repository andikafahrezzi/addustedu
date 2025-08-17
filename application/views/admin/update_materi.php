
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="">
                        <div class="card" style="width:100%;">
                            <div class="card-body">
                                <h2 class="card-title" style="color: black;">Update Data Materi</h2>
                                <hr>
                                <p class="card-text"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction.
                                </p>
                                <a href="#detail" class="btn btn-success">Saya paham dan
                                    ingin melanjutkan ⭢</a>
                            </div>
                        </div>
                    </div>
                    <div class="card card-success">
                        <div class="col-md-12 text-center">
                            <p class="registration-title font-weight-bold display-4 mt-4" style="color:black; font-size: 50px;">
                                Update Data Materi</p>
                            <p style="line-height:-30px;margin-top:-20px;">Silahkan isi data data yang diperlukan
                                dibawah </p>
                            <hr>
                        </div>
                    <div class="card-body">
    <form method="POST" action="<?= base_url('admin/materi_edit') ?>" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
        value="<?= $this->security->get_csrf_hash(); ?>" />
        <input type="hidden" name="id" value="<?= $user->id ?>">

        <!-- Nama Guru -->
        <div class="form-group">
            <label for="nip">NIP</label>
            <input readonly id="nip" type="text" class="form-control" value="<?= $user->id_guru ?>" name="id_guru">

            <label for="nama_guru">Nama Guru</label>
            <input readonly id="nama_guru" type="text" class="form-control" value="<?= $user->nama_guru ?>">
        </div>

        <!-- Mata Pelajaran -->
        <div class="form-group">
            <label for="nama_mapel">Mata Pelajaran</label>
            <input readonly id="nama_mapel" type="text" value="<?= $user->nama_mapel ?>" class="form-control">
        </div>

        <!-- Video -->
    <div class="form-group">
        <label for="linkform">Link / Embed Video</label>
        <textarea class="form-control" name="videourl" id="videourl"><?= trim($user->video) ?></textarea>
        <small class="form-text text-muted">
        Masukkan link atau kode embed video (misal: https://www.youtube.com/embed/xxxx).
        </small>
    </div>

        <!-- Modul -->
        <div class="form-group">
            <label>Upload File Materi (PDF, Word, JPG)</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="modul" class="custom-file-input">
                    <label class="custom-file-label"><?= $user->modul ?> (Upload untuk ganti)</label>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
            <label>Deskripsi Materi</label>
            <textarea class="form-control txtarea" name="deskripsi"><?= $user->deskripsi ?></textarea>
        </div>

        <!-- Link Form -->
        <div class="form-group">
            <label>Link Google Form</label>
            <textarea class="form-control txtarea" name="linkform"><?= $user->linkform ?></textarea>
        </div>

        <button type="submit" class="btn btn-success btn-lg btn-block">Update ⭢</button>
    </form>
</div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

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
   