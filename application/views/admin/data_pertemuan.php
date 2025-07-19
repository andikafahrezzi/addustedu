<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-dark">Data Pertemuan Berdasarkan Guru dan Mapel</h2>
                <hr>

                <?php if (!empty($pertemuan_grouped)): ?>
                    <?php foreach ($pertemuan_grouped as $nama_guru => $mapel_data): ?>
                        <div class="mt-4">
                            <h4>👨‍🏫 Guru: <?= $nama_guru ?></h4>

                            <?php foreach ($mapel_data as $nama_mapel => $list_pertemuan): ?>
                                <h5 class="mt-3">📘 Mata Pelajaran: <?= $nama_mapel ?></h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center bg-light">
                                                <th width="5%">No</th>
                                                <th>Pertemuan Ke</th>
                                                <th>Deskripsi Materi</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach ($list_pertemuan as $p): ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center"><?= $p->pertemuan_ke ?></td>
                                                    <td><?= $p->deskripsi ?></td>
                                                    <td><?= date('d-m-Y', strtotime($p->tanggal)) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
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
