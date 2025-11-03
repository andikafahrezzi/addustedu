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
                    <!-- TAMBAHKAN INI untuk detail total word -->
                    <div class="mt-3 p-2 bg-light rounded">
                        <small>
                            <strong>Detail Perhitungan:</strong><br>
                            Total Jawaban: <?= $total_word['total_jawaban'] ?? $total_word['total_responden'] ?> jawaban<br>
                            Total User: <?= $total_user ?> peserta
                        </small>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Data total tidak tersedia</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- GRAND MEAN (Metode Lama) -->
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

        <!-- DISTRIBUSI JAWABAN KESELURUHAN -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>📊 Distribusi Jawaban Keseluruhan</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th>Kategori</th>
                            <th>Skala</th>
                            <th>Jumlah Jawaban</th>
                            <th>Rata-rata per User</th>
                            <th>Perhitungan</th>
                            <th>Sub Total</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $skala_labels = [
                            5 => 'Sangat Setuju',
                            4 => 'Setuju', 
                            3 => 'Netral',
                            2 => 'Tidak Setuju',
                            1 => 'Sangat Tidak Setuju'
                        ];
                        
                        $total_all_jawaban = 0;
                        $total_skor_kumulatif = 0;
                        
                        // Inisialisasi array untuk menyimpan data setiap skala
                        $data_skala = [];
                        for ($i = 1; $i <= 5; $i++) {
                            $data_skala[$i] = [
                                'jumlah_jawaban' => 0,
                                'sub_total' => 0,
                                'persentase' => 0
                            ];
                        }
                        
                        // Hitung total semua jawaban dan total skor
                        foreach ($distribusi_total as $dist) {
                            $total_all_jawaban += $dist->total_jawaban;
                            $total_skor_kumulatif += $dist->jawaban_skala * $dist->total_jawaban;
                            $data_skala[$dist->jawaban_skala] = [
                                'jumlah_jawaban' => $dist->total_jawaban,
                                'sub_total' => $dist->jawaban_skala * $dist->total_jawaban,
                                'persentase' => $total_all_jawaban > 0 ? ($dist->total_jawaban / $total_all_jawaban) * 100 : 0
                            ];
                        }
                        
                        for ($i = 5; $i >= 1; $i--): 
                            $data = $data_skala[$i];
                            $rata_per_user = $total_user > 0 ? number_format($data['jumlah_jawaban'] / $total_user, 1) : 0;
                        ?>
                        <tr>
                            <td><?= $skala_labels[$i] ?></td>
                            <td><strong><?= $i ?></strong></td>
                            <td><strong><?= $data['jumlah_jawaban'] ?> jawaban</strong></td>
                            <td>≈ <?= $rata_per_user ?> per user</td>
                            <td><?= $data['jumlah_jawaban'] ?> × <?= $i ?></td>
                            <td>= <?= $data['sub_total'] ?></td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar 
                                        <?= $i == 5 ? 'bg-success' : '' ?>
                                        <?= $i == 4 ? 'bg-primary' : '' ?>
                                        <?= $i == 3 ? 'bg-warning' : '' ?>
                                        <?= $i == 2 ? 'bg-danger' : '' ?>
                                        <?= $i == 1 ? 'bg-dark' : '' ?>
                                    " style="width: <?= $data['persentase'] ?>%">
                                        <?= number_format($data['persentase'], 1) ?>%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endfor; ?>
                        
                        <!-- TOTAL -->
                        <tr class="table-info">
                            <td colspan="2"><strong>TOTAL</strong></td>
                            <td><strong><?= $total_all_jawaban ?> jawaban</strong></td>
                            <td><strong><?= $total_user ?> user</strong></td>
                            <td><strong>Σ</strong></td>
                            <td><strong>= <?= $total_skor_kumulatif ?></strong></td>
                            <td><strong>100%</strong></td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- RINGKASAN PERHITUNGAN -->
                <div class="alert alert-info mt-3">
                    <h6>📈 Ringkasan Perhitungan Keseluruhan:</h6>
                    <?php
                    $total_pertanyaan = count($pertanyaan);
                    $skor_maksimal_total = $total_all_jawaban * 5;
                    $persentase_total = $skor_maksimal_total > 0 ? ($total_skor_kumulatif / $skor_maksimal_total) * 100 : 0;
                    $jawaban_per_user = $total_user > 0 ? number_format($total_all_jawaban / $total_user, 1) : 0;
                    ?>
                    <p class="mb-1">• <strong>Total User:</strong> <?= $total_user ?> peserta</p>
                    <p class="mb-1">• <strong>Total Pertanyaan:</strong> <?= $total_pertanyaan ?> pertanyaan</p>
                    <p class="mb-1">• <strong>Total Jawaban:</strong> <?= $total_all_jawaban ?> jawaban 
                        (≈ <?= $jawaban_per_user ?> jawaban per user)</p>
                    <p class="mb-1">• <strong>Total Skor:</strong> <?= $total_skor_kumulatif ?> 
                        (dari <?= $total_all_jawaban ?> jawaban × skala 5 = <?= $skor_maksimal_total ?> maksimal)</p>
                    <p class="mb-0">• <strong>Persentase Keseluruhan:</strong> <?= number_format($persentase_total, 2) ?>%</p>
                </div>
                
                <!-- SUMMARY STATS - SEMUA SKALA 1-5 -->
                <div class="row mt-3">
                    <div class="col-md-2">
                        <div class="card text-white bg-success">
                            <div class="card-body text-center">
                                <h4><?= $data_skala[5]['jumlah_jawaban'] ?></h4>
                                <p class="mb-0">Sangat Setuju</p>
                                <small><?= number_format($data_skala[5]['persentase'], 1) ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-white bg-primary">
                            <div class="card-body text-center">
                                <h4><?= $data_skala[4]['jumlah_jawaban'] ?></h4>
                                <p class="mb-0">Setuju</p>
                                <small><?= number_format($data_skala[4]['persentase'], 1) ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-white bg-warning">
                            <div class="card-body text-center">
                                <h4><?= $data_skala[3]['jumlah_jawaban'] ?></h4>
                                <p class="mb-0">Netral</p>
                                <small><?= number_format($data_skala[3]['persentase'], 1) ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-white bg-danger">
                            <div class="card-body text-center">
                                <h4><?= $data_skala[2]['jumlah_jawaban'] ?></h4>
                                <p class="mb-0">Tidak Setuju</p>
                                <small><?= number_format($data_skala[2]['persentase'], 1) ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-white bg-dark">
                            <div class="card-body text-center">
                                <h4><?= $data_skala[1]['jumlah_jawaban'] ?></h4>
                                <p class="mb-0">Sangat Tidak Setuju</p>
                                <small><?= number_format($data_skala[1]['persentase'], 1) ?>%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-white bg-secondary">
                            <div class="card-body text-center">
                                <h4><?= $total_user ?></h4>
                                <p class="mb-0">Total User</p>
                                <small><?= $total_pertanyaan ?> pertanyaan</small>
                            </div>
                        </div>
                    </div>
                </div>
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
                        
                        <!-- TAMPILAN SEBELUMNYA -->
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
<p><strong>Total Jawaban:</strong> <?= $h['total_jawaban'] ?? $h['total_responden'] ?> jawaban</p>                                        <p><strong>Total Skor:</strong> <?= $h['total_skor'] ?></p>
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

                        <!-- Progress bar distribusi -->
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