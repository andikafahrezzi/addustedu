<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Tambah Data Kelas</h2>
                <hr>
                <p class="card-text">Lengkapi form berikut untuk menambahkan kelas baru ke sistem Addustedu.</p>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger">Nama Kelas Sudah Ada, Nama Kelas Tidak Boleh Sama</div>
                <?php endif; ?>

                <form action="<?= base_url('admin/simpan_kelas') ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                            value="<?= $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <label for="nama_kelas">Kode Kelas</label>
                        <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" required>
                    </div>

                    <div class="form-group">
                        <label for="tingkat">Tingkat</label>
                        <input type="text" class="form-control" name="tingkat" id="tingkat" required>
                    </div>

                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" id="jurusan">
                    </div>

                    <button type="submit" class="btn btn-success">Simpan ⭢</button>
                    <a href="<?= base_url('admin/kelas') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
