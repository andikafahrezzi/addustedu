<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Hasil Analisis: <?= $kuisioner->judul ?></h2>
                <hr>
                <p class="card-text">Rekapitulasi jawaban responden untuk kuisioner ini.</p>
                <a href="<?= base_url('kuisioner') ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <?php foreach ($pertanyaan as $p): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5><?= $p->pertanyaan ?></h5>
                    <hr>

                    <?php if ($p->tipe_jawaban == 'skala'): ?>
                        <?php $stat = $hasil[$p->id]; ?>
                        <p>Total Respon: <?= $stat->total_respon ?></p>
                        <p>Rata-rata: <?= number_format($stat->rata_rata, 2) ?></p>
                        <p>Min: <?= $stat->nilai_min ?> | Max: <?= $stat->nilai_max ?></p>

                        <!-- Progress bar distribusi 1–5 -->
                        <div class="mt-3">
                            <?php for ($i = $p->skala_min; $i <= $p->skala_max; $i++): ?>
                                <?php 
                                $count = $this->db->where('kuisioner_id', $kuisioner->id)
                                                  ->where('pertanyaan_id', $p->id)
                                                  ->where('jawaban_skala', $i)
                                                  ->count_all_results('kuisioner_jawaban');
                                $percent = $stat->total_respon > 0 ? ($count / $stat->total_respon) * 100 : 0;
                                ?>
                                <p><?= $i ?> (<?= $percent ?>%)</p>
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            <?php endfor; ?>
                        </div>

                    <?php elseif ($p->tipe_jawaban == 'pilihan'): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Opsi</th><th>Jumlah</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hasil[$p->id] as $row): ?>
                                    <tr>
                                        <td><?= $row->jawaban_pilihan ?></td>
                                        <td><?= $row->total ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php else: ?>
                        <ul>
                            <?php foreach ($hasil[$p->id] as $row): ?>
                                <li><?= $row->jawaban_text ?> <span class="text-muted">(<?= $row->created_at ?>)</span></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</div>
