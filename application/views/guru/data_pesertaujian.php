<h3>Daftar Peserta Ujian</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Total Score</th>
            <th>Waktu Dikerjakan</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($peserta)) : ?>
            <?php $no = 1; foreach ($peserta as $p) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($p['nis']) ?></td>
                <td><?= htmlspecialchars($p['nama']) ?></td>
                <td><?= $p['nama_kelas'] ?></td>
                <td><?= number_format($p['total_nilai'], 2) ?></td>
                <td><?= $p['waktu_dikerjakan'] ? date('d M Y H:i', strtotime($p['waktu_dikerjakan'])) : '-' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center">Belum ada peserta yang mengerjakan ujian.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
