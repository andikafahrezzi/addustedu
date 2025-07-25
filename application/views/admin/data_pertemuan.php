<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
                        <div class="card-body">
                            <h2 class="card-title" style="color: black;">Management Data Pertemuan addustedu</h2>
                            <hr>
                            <p class="card-text"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction.</p>
                            <a href="<?= base_url('admin/add_pertemuan') ?>" class="btn btn-success">Tambah
                                Data Pertemuan ⭢</a>
                        </div>
                    </div>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-dark">Data Pertemuan Berdasarkan Guru dan Mapel</h2>
                <hr>

                <?php if (!empty($pertemuan_grouped)): ?>
    <?php foreach ($pertemuan_grouped as $nama_guru => $tingkat_data): ?>
        <div class="mt-4">
            <h4>👨‍🏫 Guru: <?= $nama_guru ?></h4>

            <?php foreach ($tingkat_data as $tingkat => $kelas_data): ?>
                <h5 class="mt-3">🏫 Tingkat: <?= $tingkat ?></h5>

                <?php foreach ($kelas_data as $nama_kelas => $list_pertemuan): ?>
                    <h6 class="mt-2">📚 Kelas: <?= $nama_kelas ?></h6>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center bg-light">
                                    <th width="5%">No</th>
                                    <th>Pertemuan Ke</th>
                                    <th>Deskripsi Materi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($list_pertemuan as $p): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class="text-center"><?= $p->pertemuan_ke ?></td>
                                        <td><?= $p->deskripsi ?></td>
                                        <td><?= date('d-m-Y', strtotime($p->tanggal)) ?></td>
                                        <td class="text-center">
                                        <a href="<?= base_url('admin/edit/'.$p->id_pertemuan) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= base_url('admin/delete_pertemuan/'.$p->id_pertemuan) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus pertemuan ini?')"><i class="fas fa-trash"></i></a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-muted">Belum ada data pertemuan.</p>
<?php endif; ?>

            </div>
        </div>
    </section>
</div>
