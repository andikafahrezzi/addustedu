<!-- Tampilkan daftar pertemuan yang sudah dipakai -->


<!-- Form Edit Materi -->
<form method="POST" action="<?= base_url('guru/materi_edit/' . $materi->id) ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $materi->id ?>">
    <input type="hidden" name="id_guru" value="<?= $materi->id_guru ?>">

    <div class="form-group">
        <label for="nama_guru">Nama Guru</label>
        <input readonly id="nama_guru" type="text" class="form-control" value="<?= $materi->nama_guru ?>" name="nama_guru">
    </div>
    <?php if (!empty($pertemuan_terpakai)) : ?>
    <div class="alert alert-warning">
        <strong>Perhatian!</strong> Pertemuan yang sudah digunakan untuk <strong><?= $materi->nama_mapel ?></strong> kelas <strong><?= $materi->kelas ?></strong>:
        <ul>
            <?php foreach ($pertemuan_terpakai as $p) : ?>
                <li>Pertemuan ke-<?= $p['pertemuan'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
    <div class="form-group">
        <label for="pertemuan">Pertemuan Ke-</label>
        <input type="number" name="pertemuan" id="pertemuan" class="form-control" min="1" value="<?= $materi->pertemuan ?>" required>
    </div>

    <div class="form-group">
        <label for="nama_mapel">Mata Pelajaran</label>
        <input readonly id="nama_mapel" type="text" value="<?= $materi->nama_mapel ?>" class="form-control" name="nama_mapel">
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="custom-file">
                <input type="file" name="video" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01"> <?= $materi->video ?> Upload Video Materi Disini</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Upload File Materi (PDF, Word, JPG)</label>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" name="modul" class="custom-file-input">
                <label class="custom-file-label"> <?= $materi->modul ?> Pilih file</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi Materi</label>
        <textarea class="form-control txtarea" name="deskripsi" id="deskripsi" rows="3"><?= trim($materi->deskripsi) ?></textarea>
    </div>

    <div class="form-group">
        <label for="linkform">Link Google Form</label>
        <textarea class="form-control txtarea" name="linkform" id="linkform"><?= trim($materi->linkform) ?></textarea>
    </div>
    <div class="form-group">
                                        <label for="inputState">Kelas</label>
                                        <select required id="inputState" name="kelas" class="form-control" >
                                            <option selected value="<?= $materi->nama_mapel ?>">Pilih disini</option>
                                            <option value="X">X ( Kelas Sepuluh )</option>
                                            <option value="XI">XI ( Kelas Sebelas )</option>
                                            <option value="XII">XII ( Kelas Dua Belas )</option>
                                        </select>
                                    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block">Update ⭢</button>
    </div>
</form>

<!-- Validasi JS Pertemuan -->
<?php
    $dipakai = array_column($pertemuan_terpakai ?? [], 'pertemuan');
?>
<script>
    const pertemuanTerpakai = <?= json_encode($dipakai) ?>;
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

<?php if ($this->session->flashdata('error-per')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $this->session->flashdata('error-per'); ?>',
            footer: 'Cek kembali data yang Anda inputkan.'
        });
    </script>
<?php endif; ?>
