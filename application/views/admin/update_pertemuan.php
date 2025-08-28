<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Pertemuan</h1>
        </div>

        <div class="section-body">


            <form method="post" action="<?= base_url('admin/update_pertemuan/' . $pertemuan->id) ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                value="<?= $this->security->get_csrf_hash(); ?>" />
                <div class="form-group">
                    <label for="id_materi">Materi</label>
                    <select name="id_materi" id="id_materi" class="form-control">
                        <?php foreach ($materi_list as $m): ?>
                            <option value="<?= $m->id ?>" <?= ($m->id == $pertemuan->id_materi ? 'selected' : '') ?>>
                                <?= $m->nama_mapel ?> - <?= $m->deskripsi ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kelas">Kelas</label>
                    <select name="id_kelas" class="form-control" required>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k->id ?>" <?= $pertemuan->id_kelas == $k->id ? 'selected' : '' ?>>
                                <?= $k->tingkat . ' ' . $k->nama_kelas ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pertemuan_ke">Pertemuan Ke</label>
                    <input type="number" name="pertemuan_ke" class="form-control" value="<?= $pertemuan->pertemuan_ke ?>" required>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= $pertemuan->tanggal ?>" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?= base_url('admin/data_pertemuan') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </section>
</div>