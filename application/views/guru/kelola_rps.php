<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Upload RPS Baru</h2>
                <hr>
                <p class="card-text">Silakan pilih Mata Pelajaran, Kelas, Semester, dan unggah file RPS Anda (PDF/DOC/DOCX).</p>
                <a href="<?= base_url('rps/data_rps') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar RPS
                </a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0,0,0,0.03) 0px 4px 8px 0px">
                    <form action="<?= site_url('rps/proses_upload') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <select name="guru_mapel_id" class="form-control" required>
                                <option value="">-- Pilih Mapel --</option>
                                <?php foreach($mapel_list as $m): ?>
                                    <option value="<?= $m->guru_mapel_id ?>"><?= htmlspecialchars($m->nama_mapel) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="kelas_id" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach($kelas_list as $k): ?>
                                    <option value="<?= $k->id ?>"><?= htmlspecialchars($k->nama_kelas) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Semester</label>
                            <input type="text" name="semester" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>File RPS</label>
                            <input type="file" name="file_rps" class="form-control" accept=".pdf,.doc,.docx" required>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload"></i> Upload RPS
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
