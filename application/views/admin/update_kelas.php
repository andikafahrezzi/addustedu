<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Edit Data Kelas</h2>
                <hr>
                <p class="card-text">Perbarui informasi kelas berikut sesuai kebutuhan.</p>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger"><?= validation_errors() ?></div>
                <?php endif; ?>
                <form action="<?= base_url('admin/update_kelas/' . $kelas_edit->id) ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas (Kode)</label>
                        <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" required value="<?= $kelas_edit->nama_kelas ?>">
                    </div>

                    <div class="form-group">
                        <label for="tingkat">Tingkat</label>
                        <input type="text" class="form-control" name="tingkat" id="tingkat" required value="<?= $kelas_edit->tingkat ?>">
                    </div>

                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" id="jurusan" value="<?= $kelas_edit->jurusan ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Update ⭢</button>
                    <a href="<?= base_url('admin/kelas') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
