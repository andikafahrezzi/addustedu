<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Update RPS</h2>
                <hr>
                <p class="card-text">Edit data RPS berikut sesuai kebutuhan. Anda dapat mengubah Mata Pelajaran, Kelas, Semester, atau mengganti file RPS.</p>
                <a href="<?= base_url('rps/data_rps') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar RPS
                </a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0,0,0,0.03) 0px 4px 8px 0px">
                    <form action="<?= site_url('rps/proses_update/'.$rps->id_rps) ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <select name="guru_mapel_id" class="form-control" required>
                                <option value="">-- Pilih Mapel --</option>
                                <?php foreach($mapel_list as $m): ?>
                                    <option value="<?= $m->guru_mapel_id ?>" <?= ($m->guru_mapel_id == $rps->guru_mapel_id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($m->nama_mapel) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="kelas_id" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach($kelas_list as $k): ?>
                                    <option value="<?= $k->id ?>" <?= ($k->id == $rps->kelas_id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k->nama_kelas) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Semester</label>
                            <input type="text" name="semester" class="form-control" value="<?= htmlspecialchars($rps->semester) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>File RPS (biarkan kosong jika tidak ingin mengganti)</label>
                            <input type="file" name="file_rps" class="form-control" accept=".pdf,.doc,.docx">
                            <small>File saat ini: <a href="<?= base_url('./assets/rps_uploads/'.$rps->file_rps) ?>" target="_blank"><?= htmlspecialchars($rps->file_rps) ?></a></small>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update RPS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- SweetAlert Notifications -->
<?php if ($this->session->flashdata('success')) : ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '<?= $this->session->flashdata('success'); ?>',
    showConfirmButton: false,
    timer: 2500
});
</script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '<?= $this->session->flashdata('error'); ?>',
    showConfirmButton: false,
    timer: 2500
});
</script>
<?php endif; ?>
