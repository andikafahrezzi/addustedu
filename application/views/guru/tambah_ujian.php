<div class="container">
    <h2>Tambah Ujian Baru</h2>
    <form method="post" action="<?= site_url('guru/simpan_ujian') ?>">
        <div class="form-group">
            <label for="nama_ujian">Nama Ujian</label>
            <input type="text" class="form-control" id="nama_ujian" name="nama_ujian" required>
        </div>
        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
        </div>
        <div class="form-group">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
        </div>
        <div class="form-group">
            <label for="durasi">Durasi (Menit)</label>
            <input type="number" class="form-control" id="durasi" name="durasi" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>
        <div class="form-group">
            <label for="id_materi">Mata Pelajaran</label>
            <select name="materi_id" class="form-control" required>
                        <option value="">Pilih Materi</option>
                        <?php foreach ($materi_list as $materi): ?>
                            <option value="<?php echo $materi->id; ?>">
                            <?php echo $materi->id; ?>
                            <?php echo htmlspecialchars($materi->kelas); ?>
                                <?php echo htmlspecialchars($materi->deskripsi); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Ujian</button>
    </form>
</div>
