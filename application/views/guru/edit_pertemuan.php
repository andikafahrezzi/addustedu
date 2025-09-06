<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h4>✏️ Edit Pertemuan</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= site_url('pertemuan/update') ?>" method="post">
                            <input type="hidden" name="id_pertemuan" value="<?= $pertemuan->id ?>">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                        value="<?= $this->security->get_csrf_hash(); ?>" />
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <input type="text" class="form-control" value="<?= $pertemuan->nama_mapel ?>" readonly>
                                <small class="text-muted">Tidak dapat diubah untuk menjaga konsistensi data</small>
                            </div>

                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control" value="Kelas <?= $pertemuan->nama_kelas ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label>Materi</label>
                                <input type="text" class="form-control" value="<?= $pertemuan->deskripsi ?>" readonly>
                                <input type="hidden" name="id_materi" value="<?= $pertemuan->id_materi ?>">
                                <input type="hidden" name="id_kelas" value="<?= $pertemuan->id_kelas ?>">
                            </div>

                            <div class="form-group">
                                <label>Pertemuan Ke- *</label>
                                <input type="number" name="pertemuan_ke" class="form-control" value="<?= $pertemuan->pertemuan_ke ?>" min="1" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Pertemuan *</label>
                                <input type="date" name="tanggal" class="form-control" value="<?= $pertemuan->tanggal ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Pertemuan</button>
                            <a href="<?= site_url('pertemuan') ?>" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>