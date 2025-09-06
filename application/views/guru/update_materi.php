<?php if ($this->session->flashdata('error-per')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error-per'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success-edit')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success-edit'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<form method="POST" action="<?= base_url('guru/materi_edit/' . $materi->id) ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $materi->id ?>">
    <input type="hidden" name="id_guru" value="<?= $materi->id_guru ?>">
    <input type="hidden" name="modul_lama" value="<?= $materi->modul ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

    <div class="form-group">
        <label for="nama_guru">Nama Guru</label>
        <input readonly id="nama_guru" type="text" class="form-control" value="<?= $materi->nama_guru ?>">
    </div>

    <?php if (!empty($pertemuan_terpakai)) : ?>
        <div class="alert alert-warning">
            <strong>Perhatian!</strong> Pertemuan yang sudah digunakan untuk <strong><?= $materi->nama_mapel ?></strong> kelas <strong><?= $materi->nama_kelas ?></strong>:
            <ul>
                <?php foreach ($pertemuan_terpakai as $p) : ?>
                    <li>Pertemuan ke-<?= $p['pertemuan'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <div class="form-group">
        <label for="mapel">Mata Pelajaran</label>
        <input readonly type="text" class="form-control" value="<?= $materi->nama_mapel ?>">
        <input type="hidden" name="id_mapel" value="<?= $materi->id_mapel ?>">
    </div>

    <div class="form-group">
        <label for="id_kelas">Kelas</label>
        <select required id="id_kelas" name="id_kelas" class="form-control">
            <option value="<?= $materi->id_kelas ?>" selected>Kelas: <?= $materi->nama_kelas ?></option>
            <?php foreach ($kelas as $k): ?>
                <?php if ($k->id != $materi->id_kelas): ?>
                    <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="linkform">Link / Embed Video</label>
        <textarea class="form-control" name="videourl" id="videourl"><?= trim($materi->video) ?></textarea>
        <small class="form-text text-muted">
        Masukkan link atau kode embed video (misal: https://www.youtube.com/embed/xxxx).
        </small>
    </div>

    <div class="form-group">
        <label>Upload File Materi (PDF, Word, JPG)</label>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" name="modul" class="custom-file-input">
                <label class="custom-file-label"><?= $materi->modul ?> Pilih file</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi Materi</label>
        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"><?= trim($materi->deskripsi) ?></textarea>
    </div>

    <div class="form-group">
        <label for="linkform">Link Google Form</label>
        <textarea class="form-control" name="linkform" id="linkform"><?= trim($materi->linkform) ?></textarea>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block">Update ⭢</button>
    </div>
</form>


<script>
    const pertemuanTerpakai = <?= json_encode(array_column($pertemuan_terpakai ?? [], 'pertemuan')) ?>;
    const inputPertemuan = document.getElementById('pertemuan');
    const pertemuanLama = parseInt("<?= $materi->pertemuan ?>");

    inputPertemuan.addEventListener('input', function () {
        const nilai = parseInt(this.value);
        if (pertemuanTerpakai.includes(nilai) && nilai !== pertemuanLama) {
            alert("❌ Pertemuan ke-" + nilai + " sudah digunakan untuk kelas dan mapel ini!");
            this.value = "";
            this.focus();
        }
    });
</script>
