<h2>Daftar Tugas Siswa per Materi</h2>

<?php if (!empty($materi_list)): ?>
    <?php foreach ($materi_list as $materi_id => $tugas): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Materi ID: <?= $materi_id ?></strong>
            </div>
            <div class="card-body">
                <?php if (!empty($tugas)): ?>
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
                            <?php foreach ($tugas as $t): ?>
                                <tr>
                                    <td><?= $t->nama_siswa ?></td>
                                    <td><?= $t->original_filename ?></td>
                                    <td><?= round($t->file_size / 1024, 2) ?> KB</td>
                                    <td><?= $t->file_type ?></td>
                                    <td><?= date('d M Y H:i', strtotime($t->dikirim_pada)) ?></td>
                                    <td>
                                        <a href="<?= base_url('assets/materi_tugas/' . $t->file_path) ?>" class="btn btn-sm btn-success" download>
                                            Unduh
                                        </a>
                                        <a href="<?= base_url('guru/lihat_tugas/' . $t->materi_id) ?>" class="btn btn-sm btn-success">
                                            lihat
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Tidak ada tugas pada materi ini.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Belum ada tugas yang dikirim.</p>
<?php endif; ?>
