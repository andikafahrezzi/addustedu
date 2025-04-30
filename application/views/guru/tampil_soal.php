<div class="container">
    <h2>Soal Ujian</h2>
    <h4>Ujian: <?= $id_ujian ?></h4>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Soal</th>
                <th>Pilihan Jawaban</th>
                <th>Kunci Jawaban</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($soal_list as $key => $s): ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $s['pertanyaan'] ?></td>
                    <td>
                        A: <?= $s['pilihan_a'] ?><br>
                        B: <?= $s['pilihan_b'] ?><br>
                        C: <?= $s['pilihan_c'] ?><br>
                        D: <?= $s['pilihan_d'] ?>
                    </td>
                    <td><?= $s['kunci_jawaban'] ?></td>
                    <td>
                        <a href="<?= site_url('guru/edit_soal/' . $s['id_soal']) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= site_url('guru/hapus_soal/' . $s['id_soal']) ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= site_url('guru/tambah_soal_ujian/' . $id_ujian) ?>" class="btn btn-success">Tambah Soal</a>
</div>
