<div class="container-fluid">
    <h3>📊 Rekap Absensi Pertemuan</h3>
    
    <!-- VALIDITY WARNING -->
    <?php if (!$validity_info['is_valid']): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Data Perlu Diupdate!</strong> 
        Ada perubahan setting atau tanggal pertemuan. 
        <a href="<?= base_url('absensi/hitung/'.$id_pertemuan) ?>" class="alert-link">
            Klik di sini untuk update data absensi
        </a>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    <?php else: ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <strong>Data Terkini</strong> 
        Terakhir dihitung: <?= $validity_info['last_calculated'] ? date('d/m/Y H:i', strtotime($validity_info['last_calculated'])) : 'Belum pernah' ?>
    </div>
    <?php endif; ?>

<!-- Di absensi_pertemuan.php - modifikasi tabel -->
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <!-- HAPUS KOLOM KELAS -->
            <th class="text-center">Komentar</th>
            <th class="text-center">Hari Berbeda</th>
            <th class="text-center">Quiz</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
    <?php if(!empty($absensi)): ?>
        <?php foreach($absensi as $a): ?>
        <tr>
            <td><?= $a['nis'] ?></td>
            <td><?= $a['nama'] ?></td>
            <!-- TIDAK ADA TD UNTUK KELAS -->
            <td class="text-center"><?= $a['total_komentar'] ?></td>
            <td class="text-center"><?= $a['hari_berbeda'] ?></td>
            <td class="text-center">
                <?= $a['quiz_completed'] ? '✅' : '❌' ?>
            </td>
            <td class="text-center">
                <?php if ($a['status'] == 'hadir'): ?>
                    <span class="badge badge-success p-2">Hadir</span>
                <?php else: ?>
                    <span class="badge badge-danger p-2">Tidak Hadir</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center">Tidak ada data absensi</td> <!-- colspan jadi 6 -->
        </tr>
    <?php endif; ?>
    </tbody>
</table>

    <!-- Tombol Aksi -->
    <div class="mb-3">
        <a href="<?= base_url('absensi/hitung/'.$id_pertemuan) ?>" class="btn btn-warning">
            🔄 Hitung Ulang Absensi
        </a>
        <a href="<?= base_url('pertemuan/index') ?>" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>
</div>