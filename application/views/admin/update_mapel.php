<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Edit Mata Pelajaran</h2>
                <hr>
                <p class="card-text">
                    Perbarui informasi mata pelajaran sesuai kebutuhan.
                </p>

                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger"><?= validation_errors() ?></div>
                <?php endif; ?>

                <form action="<?= base_url('admin/update_mapel/' . $mapel_edit->id) ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <label for="nama_mapel">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" name="nama_mapel" id="nama_mapel" value="<?= $mapel_edit->nama_mapel ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi </label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi" value="<?= $mapel_edit->deskripsi ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update ⭢</button>
                    <a href="<?= base_url('admin/data_mapel') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
