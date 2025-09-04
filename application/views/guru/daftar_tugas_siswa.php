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
                                <p><strong><?= $p['jumlah_tugas'] ?></strong> siswa sudah mengumpulkan tugas.</p>
                                <a href="<?= base_url('guru/lihat_tugas/' . $p['id_pertemuan']) ?>" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
