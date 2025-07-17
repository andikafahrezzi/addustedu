<h2>Daftar Tugas Siswa per Materi</h2>

<?php foreach ($materi_list as $materi_id => $pertemuan): ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Mata Pelajaran: <?= $pertemuan['nama_mapel'] ?></strong> |
            <strong>Kelas: <?= $pertemuan['nama_kelas'] ?></strong>   |
            <strong>Pertemuan: <?= $pertemuan['pertemuan_ke'] ?></strong>
            <br><small><?= $pertemuan['judul_materi'] ?></small>
        </div>

        <div class="card-body">
            <?php if (!empty($pertemuan['tugas'])): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>Jenis</th>
                            <th>Dikirim Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pertemuan['tugas'] as $t): ?>
                            <tr>
                                <td><?= $t->nama_siswa ?></td>
                                <td><?= $t->original_filename ?></td>
                                <td><?= round($t->file_size / 1024, 2) ?> KB</td>
                                <td><?= $t->file_type ?></td>
                                <td><?= date('d M Y H:i', strtotime($t->dikirim_pada)) ?></td>
                                <td>
                                    <a href="<?= base_url('guru/download_tugas/' . $t->id) ?>" class="btn btn-sm btn-success">
                                        Unduh
                                    </a>
                                    <a href="<?= base_url('guru/lihat_tugas/' . $t->id_pertemuan) ?>" class="btn btn-sm btn-success">
                                        lihat
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning mb-0">
                    Belum ada tugas yang dikirim untuk pertemuan ini.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
