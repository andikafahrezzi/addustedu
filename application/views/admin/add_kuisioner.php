<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Tambah Data Kuisioner</h2>
                <hr>
                <p class="card-text">Lengkapi form berikut untuk menambahkan kuisioner baru ke sistem Ctkarya.</p>

                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger"><?= validation_errors() ?></div>
                <?php endif; ?>

                <form action="<?= base_url('kuisioner/create') ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                           value="<?= $this->security->get_csrf_hash(); ?>" />

                    <div class="form-group">
                        <label for="judul">Judul Kuisioner</label>
                        <input type="text" class="form-control" name="judul" id="judul" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="target">Target</label>
                        <select name="target" id="target" class="form-control" required>
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                            <option value="all">Semua</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select name="is_active" id="is_active" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan ⭢</button>
                    <a href="<?= base_url('kuisioner') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
