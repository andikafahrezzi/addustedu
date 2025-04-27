<div class="container">
    <h2>Edit Ujian</h2>
    <form method="post" action="<?= site_url('guru/simpan_edit_ujian/'.$ujian['id_ujian']) ?>">
        <div class="form-group">
            <label for="nama_ujian">Nama Ujian</label>
            <input type="text" class="form-control" id="nama_ujian" name="nama_ujian" value="<?= htmlspecialchars($ujian['nama_ujian']) ?>" required>
        </div>
        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= $ujian['tanggal_mulai'] ?>" required>
        </div>
        <div class="form-group">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= $ujian['tanggal_selesai'] ?>" required>
        </div>
        <div class="form-group">
            <label for="durasi">Durasi (Menit)</label>
            <input type="number" class="form-control" id="durasi" name="durasi" value="<?= $ujian['durasi'] ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="aktif" <?= $ujian['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $ujian['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>
        <div class="form-group">
            <label for="id_materi">Mata Pelajaran</label>
            <select name="materi_id" class="form-control" required>
                <option value="">Pilih Materi</option>
                <?php foreach ($materi_list as $materi): ?>
                    <option value="<?php echo $materi->id; ?>" <?= $materi->id == $ujian['id_materi'] ? 'selected' : '' ?>>
                        <?php echo htmlspecialchars($materi->nama_mapel); ?> - <?php echo htmlspecialchars($materi->kelas); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
