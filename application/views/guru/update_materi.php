<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="">
            <div class="card" style="width:100%;">
                <div class="card-body">
                    <h2 class="card-title" style="color: black;">Update Data Materi</h2>
                    <hr>
                    <p class="card-text"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request?</p>
                    <a href="#detail" class="btn btn-success">Saya paham dan ingin melanjutkan ⭢</a>
                </div>
            </div>
        </div>

        <div class="card card-success">
            <div class="col-md-12 text-center">
                <p class="registration-title font-weight-bold display-4 mt-4" style="color:black; font-size: 50px;">
                    Update Data Materi</p>
                <p style="line-height:-30px;margin-top:-20px;">Silahkan isi data data yang diperlukan dibawah </p>
                <hr>
            </div>
            
            <div class="card-body">
                <?php $m = $materi; ?>
                <form method="POST" action="<?= base_url('guru/materi_edit/' . $materi->id) ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $materi->id ?>">
                    <input type="hidden" name="id_guru" value="<?= $materi->id_guru ?>">

                    <div class="form-group">
                        <label for="nip">Nip</label>
                        <input readonly id="nip" type="text" class="form-control" value="<?= $materi->id_guru ?>" name="nama_guru">
                        <?= form_error('nip', '<small class="text-danger">', '</small>'); ?>

                        <label for="nama_guru">Nama Guru</label>
                        <input readonly id="nama_guru" type="text" class="form-control" value="<?= $m->nama_guru ?>" name="nama_guru">
                        <?= form_error('nama_guru', '<small class="text-danger">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="nama_mapel">Mata Pelajaran</label>
                        <input readonly id="nama_mapel" type="text" value="<?= $m->nama_mapel ?>" class="form-control" name="nama_mapel">
                        <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="video" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01"> <?= $m->video ?> Upload Video Materi Disini</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Upload File Materi (PDF, Word, JPG)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="modul" class="custom-file-input">
                                <label class="custom-file-label"> <?= $m->modul ?> Pilih file</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Materi</label>
                        <textarea class="form-control txtarea" name="deskripsi" id="deskripsi" rows="3"><?= trim($m->deskripsi) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="linkform">Link Google Form</label>
                        <textarea class="form-control txtarea" name="linkform" id="linkform"><?= trim($m->linkform) ?></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            Update ⭢
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->
