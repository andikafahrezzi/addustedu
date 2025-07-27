<div class="container mt-4">
    <h2 class="mb-4">Daftar Tugas Siswa</h2>

    <?php foreach ($materi_list as $tingkat => $mapel_data): ?>
        <h4 class="mb-3 text-success">Tingkat: <?= $tingkat ?></h4>

        <?php foreach ($mapel_data as $mapel => $kelas_data): ?>
            <h5 class="mb-2 ml-3 text-primary">Mata Pelajaran: <?= $mapel ?></h5>

            <?php foreach ($kelas_data as $kelas => $pertemuan_data): ?>
                <div class="ml-4 mb-4">
                    <h6 class="font-weight-bold text-dark">Kelas: <?= $kelas ?></h6>

                    <?php foreach ($pertemuan_data as $p): ?>
                        <div class="card shadow mb-3 ml-2">
                            <div class="card-header bg-light">
                                <strong>Pertemuan ke-<?= $p['pertemuan_ke'] ?></strong> <br>
                                <small><?= $p['judul_materi'] ?></small>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($p['tugas'])): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Nama Siswa</th>
                                                    <th>Nama File</th>
                                                    <th>Ukuran</th>
                                                    <th>Jenis</th>
                                                    <th>Dikirim Pada</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($p['tugas'] as $t): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($t->nama_siswa) ?></td>
                                                        <td><?= htmlspecialchars($t->original_filename) ?></td>
                                                        <td><?= round($t->file_size / 1024, 2) ?> KB</td>
                                                        <td><?= htmlspecialchars($t->file_type) ?></td>
                                                        <td><?= date('d M Y H:i', strtotime($t->dikirim_pada)) ?></td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('guru/download_tugas/' . $t->id) ?>" class="btn btn-sm btn-success mb-1">
                                                                <i class="fas fa-download"></i> Unduh
                                                            </a>
                                                            <a href="<?= base_url('guru/lihat_tugas/' . $t->id_pertemuan) ?>" class="btn btn-sm btn-primary mb-1">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning d-flex align-items-center mb-0">
                                        <i class="fas fa-exclamation-circle fa-lg mr-2"></i>
                                        <span>Belum ada tugas yang dikumpulkan untuk pertemuan ini.</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
