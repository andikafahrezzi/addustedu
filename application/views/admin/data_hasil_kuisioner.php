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

        <!-- HASIL TOTAL KESELURUHAN seperti Word -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Hasil Total Keseluruhan (Metode Skor Kumulatif)</h4>
            </div>
            <div class="card-body">
                <?php if (isset($total_word)): ?>
                    <p><strong>Total Skor:</strong> <?= $total_word['total_skor'] ?> dari <?= $total_word['skor_maksimal'] ?></p>
                    <p><strong>Persentase:</strong> <b><?= number_format($total_word['persentase'], 2) ?>%</b></p>
                    <p><strong>Kategori:</strong> 
                        <span class="badge 
                            <?= $total_word['kategori'] == 'Sangat Setuju' ? 'bg-success' : '' ?>
                            <?= $total_word['kategori'] == 'Setuju' ? 'bg-primary' : '' ?>
                            <?= $total_word['kategori'] == 'Netral' ? 'bg-warning' : '' ?>
                            <?= $total_word['kategori'] == 'Tidak Setuju' ? 'bg-danger' : '' ?>
                            <?= $total_word['kategori'] == 'Sangat Tidak Setuju' ? 'bg-dark' : '' ?>
                        ">
                            <?= $total_word['kategori'] ?>
                        </span>
                    </p>
                    <p><strong>Total Responden:</strong> <?= $total_word['total_responden'] ?> jawaban</p>
                <?php else: ?>
                    <p class="text-muted">Data total tidak tersedia</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- GRAND MEAN (Metode Lama) - Tetap dipertahankan -->
        <div class="card mt-3">
            <div class="card-body">
                <h4>Grand Mean (Rata-rata Keseluruhan)</h4>
                <p>
                    Rata-rata keseluruhan: <b><?= number_format($grand_mean->grand_mean ?? 0, 2); ?></b><br>
                    Jumlah Respon: <?= $grand_mean->total_respon ?? 0; ?><br>
                    Min: <?= $grand_mean->nilai_min ?? '-'; ?>, 
                    Max: <?= $grand_mean->nilai_max ?? '-'; ?>
                </p>
            </div>
        </div>

        <!-- HASIL PER PERTANYAAN -->
        <?php foreach ($pertanyaan as $p): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5><?= $p->pertanyaan ?></h5>
                    <hr>

                    <?php if ($p->tipe_jawaban == 'skala'): ?>
                        <?php $stat = $hasil[$p->id]; ?>
                        
                        <!-- TAMPILAN SEBELUMNYA (Tetap dipertahankan) -->
                        <div class="mb-3">
                            <h6>Statistik Deskriptif:</h6>
                            <p>Total Respon: <?= $stat->total_respon ?></p>
                            <p>Rata-rata: <?= number_format($stat->rata_rata, 2) ?></p>
                            <p>Min: <?= $stat->nilai_min ?> | Max: <?= $stat->nilai_max ?></p>
                        </div>

                        <!-- TAMPILAN BARU seperti Word -->
                        <?php if (isset($hasil_word[$p->id])): ?>
                            <?php $h = $hasil_word[$p->id]; ?>
                            <div class="mt-4">
                                <h6>Analisis Skor Kumulatif (Seperti Word):</h6>
                                
                                <!-- Tabel Distribusi -->
                                <table class="table table-bordered table-sm mt-2">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sangat Setuju (5)</th>
                                            <th>Setuju (4)</th>
                                            <th>Netral (3)</th>
                                            <th>Tidak Setuju (2)</th>
                                            <th>Sangat Tidak Setuju (1)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $h['distribusi']['ss'] ?></td>
                                            <td><?= $h['distribusi']['s'] ?></td>
                                            <td><?= $h['distribusi']['n'] ?></td>
                                            <td><?= $h['distribusi']['ts'] ?></td>
                                            <td><?= $h['distribusi']['sts'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Hasil Perhitungan -->
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong>Total Skor:</strong> <?= $h['total_skor'] ?></p>
                                        <p><strong>Skor Maksimal:</strong> <?= $h['skor_maksimal'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Persentase:</strong> <b><?= number_format($h['persentase'], 2) ?>%</b></p>
                                        <p><strong>Kategori:</strong> 
                                            <span class="badge 
                                                <?= $h['kategori'] == 'Sangat Setuju' ? 'bg-success' : '' ?>
                                                <?= $h['kategori'] == 'Setuju' ? 'bg-primary' : '' ?>
                                                <?= $h['kategori'] == 'Netral' ? 'bg-warning' : '' ?>
                                                <?= $h['kategori'] == 'Tidak Setuju' ? 'bg-danger' : '' ?>
                                                <?= $h['kategori'] == 'Sangat Tidak Setuju' ? 'bg-dark' : '' ?>
                                            ">
                                                <?= $h['kategori'] ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Progress bar distribusi 1–5 (Tetap dipertahankan) -->
                        <div class="mt-3">
                            <h6>Distribusi Jawaban:</h6>
                            <?php for ($i = $p->skala_min; $i <= $p->skala_max; $i++): ?>
                                <?php 
                                $count = $this->db->where('kuisioner_id', $kuisioner->id)
                                                  ->where('pertanyaan_id', $p->id)
                                                  ->where('jawaban_skala', $i)
                                                  ->count_all_results('kuisioner_jawaban');
                                $percent = $stat->total_respon > 0 ? ($count / $stat->total_respon) * 100 : 0;
                                
                                // Label untuk skala
                                $label = '';
                                if ($i == 5) $label = 'Sangat Setuju';
                                elseif ($i == 4) $label = 'Setuju';
                                elseif ($i == 3) $label = 'Netral';
                                elseif ($i == 2) $label = 'Tidak Setuju';
                                elseif ($i == 1) $label = 'Sangat Tidak Setuju';
                                ?>
                                <p><?= $i ?> - <?= $label ?> (<?= number_format($percent, 1) ?>%) - <?= $count ?> responden</p>
                                <div class="progress mb-2">
                                    <div class="progress-bar 
                                        <?= $i == 5 ? 'bg-success' : '' ?>
                                        <?= $i == 4 ? 'bg-primary' : '' ?>
                                        <?= $i == 3 ? 'bg-warning' : '' ?>
                                        <?= $i == 2 ? 'bg-danger' : '' ?>
                                        <?= $i == 1 ? 'bg-dark' : '' ?>
                                    " role="progressbar" style="width: <?= $percent ?>%" 
                                    aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?= number_format($percent, 1) ?>%
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                    <?php elseif ($p->tipe_jawaban == 'pilihan'): ?>
                        <!-- Tetap sama -->
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
                        <!-- Tetap sama -->
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