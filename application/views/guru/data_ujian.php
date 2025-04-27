<div class="container">
<div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Quiz</h6>
            <a href="<?= base_url('guru/tambah_ujian') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Buat Quiz Baru
            </a>
        </div>
    <h2>Daftar Ujian yang Dibuat</h2>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Ujian</th>
                <th>Mata Pelajaran</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php var_dump($ujian_list); ?>
            <?php foreach ($ujian_list as $key => $u): ?>
                // Di view daftar_ujian.php
            

                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $u['nama_ujian'] ?></td>
                    <td><?= $u['nama_mapel'] ?></td>
                    <td><?= $u['tanggal_mulai'] ?></td>
                    <td><?= $u['tanggal_selesai'] ?></td>
                    <td><?= ucfirst($u['status']) ?></td>
                    <td>
                        <a href="<?= site_url('guru/tambah_soal_ujian/' . $u['id_ujian']) ?>" class="btn btn-info">Tambah Soal</a>
                        <a href="<?= site_url('guru/tampilkan_soal/' . $u['id_ujian']) ?>" class="btn btn-info">Lihat Soal</a>
                        <a href="<?= site_url('guru/edit_ujian/' . $u['id_ujian']) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= site_url('guru/hapus_ujian/' . $u['id_ujian']) ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
