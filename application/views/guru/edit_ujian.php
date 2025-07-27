<div class="container">
    <h2>Edit Ujian</h2>
    <form method="post" action="<?= site_url('guru/simpan_edit_ujian/' . $ujian->id_ujian) ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                        value="<?= $this->security->get_csrf_hash(); ?>" />
        <div class="form-group">
            <label for="nama_ujian">Nama Ujian</label>
            <input type="text" class="form-control" id="nama_ujian" name="nama_ujian"
                   value="<?= htmlspecialchars($ujian->nama_ujian) ?>" required>
        </div>
        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                   value="<?= date('Y-m-d', strtotime($ujian->tanggal_mulai)) ?>" required>
        </div>
        <div class="form-group">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                   value="<?= date('Y-m-d', strtotime($ujian->tanggal_selesai)) ?>" required>
        </div>
        <div class="form-group">
            <label for="durasi">Durasi (Menit)</label>
            <input type="number" class="form-control" id="durasi" name="durasi"
                   value="<?= $ujian->durasi ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="aktif" <?= $ujian->status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $ujian->status == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>
                        <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                             <label for="bobot_pg">Bobot Nilai PG (%)</label>
                             <input type="number" name="bobot_pg" value="<?= htmlspecialchars($ujian->bobot_pg) ?>" min="0" max="100" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                              <label for="bobot_essay">Bobot Nilai Essay (%)</label>
                              <input type="number" name="bobot_essay" value="<?= htmlspecialchars($ujian->bobot_essay) ?>" min="0" max="100" class="form-control" required>
                        </div>
                    </div>
                </div>
        <div class="form-group">
            <label for="materi_id">Mata Pelajaran</label>
            <select name="id_pertemuan" class="form-control" required>
                <option value="">Pilih Materi</option>
                <?php foreach ($materi_list as $materi): ?>
                    <option value="<?= $materi->id_pertemuan ?>"
                        <?= $materi->id_pertemuan == $ujian->id_pertemuan ? 'selected' : '' ?>>
                        <?= htmlspecialchars($materi->nama_mapel) ?>
                        - <?= htmlspecialchars($materi->tingkat . ' ' . $materi->nama_kelas) ?>
                        - <?= htmlspecialchars($materi->deskripsi) ?>
                        (Pertemuan <?= $materi->pertemuan_ke ?>)
                    </option>
                <?php endforeach; ?>

            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
