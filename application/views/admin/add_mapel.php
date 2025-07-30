<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Tambah Mata Pelajaran</h2>
                <hr>
                <p class="card-text">
                    Silakan lengkapi form berikut untuk menambahkan mata pelajaran baru ke sistem.
                </p>

                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger"><?= validation_errors() ?></div>
                <?php endif; ?>

                <form action="<?= base_url('admin/simpan_mapel') ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <label for="nama_mapel">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" name="nama_mapel" id="nama_mapel" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan ⭢</button>
                    <a href="<?= base_url('admin/data_mapel') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
