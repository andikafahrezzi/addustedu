<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="<?= site_url('guru/add_bank_soal') ?>">
                <!-- Pertanyaan -->
                <div class="form-group">
                    <label for="pertanyaan">Pertanyaan *</label>
                    <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="5" required><?= set_value('pertanyaan') ?></textarea>
                    <?= form_error('pertanyaan', '<small class="text-danger">', '</small>') ?>
                </div>
                
                <!-- Pilihan Jawaban -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pilihan_a">Pilihan A *</label>
                            <input type="text" name="pilihan_a" id="pilihan_a" class="form-control" value="<?= set_value('pilihan_a') ?>" required>
                            <?= form_error('pilihan_a', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pilihan_b">Pilihan B *</label>
                            <input type="text" name="pilihan_b" id="pilihan_b" class="form-control" value="<?= set_value('pilihan_b') ?>" required>
                            <?= form_error('pilihan_b', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pilihan_c">Pilihan C *</label>
                            <input type="text" name="pilihan_c" id="pilihan_c" class="form-control" value="<?= set_value('pilihan_c') ?>" required>
                            <?= form_error('pilihan_c', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pilihan_d">Pilihan D *</label>
                            <input type="text" name="pilihan_d" id="pilihan_d" class="form-control" value="<?= set_value('pilihan_d') ?>" required>
                            <?= form_error('pilihan_d', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                </div>
                
                <!-- Kunci Jawaban dan Mapel -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kunci_jawaban">Kunci Jawaban *</label>
                            <select name="kunci_jawaban" id="kunci_jawaban" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="a" <?= set_select('kunci_jawaban', 'a') ?>>A</option>
                                <option value="b" <?= set_select('kunci_jawaban', 'b') ?>>B</option>
                                <option value="c" <?= set_select('kunci_jawaban', 'c') ?>>C</option>
                                <option value="d" <?= set_select('kunci_jawaban', 'd') ?>>D</option>
                            </select>
                            <?= form_error('kunci_jawaban', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tingkat_kesulitan">Tingkat Kesulitan</label>
                            <select name="tingkat_kesulitan" id="tingkat_kesulitan" class="form-control">
                                <option value="mudah" <?= set_select('tingkat_kesulitan', 'mudah') ?>>Mudah</option>
                                <option value="sedang" <?= set_select('tingkat_kesulitan', 'sedang', TRUE) ?>>Sedang</option>
                                <option value="sulit" <?= set_select('tingkat_kesulitan', 'sulit') ?>>Sulit</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mapel_diajarkan">Mata Pelajaran *</label>
                            <input type="text" name="mapel_diajarkan" id="mapel_diajarkan" class="form-control" 
                                   value="<?= $mapel_guru ?>" readonly required>
                            <small class="text-muted">Mapel ini sesuai dengan yang Anda ajarkan</small>
                        </div>
                    </div>
                </div>
                
                <!-- Tipe Kognitif -->
                <div class="form-group">
                    <label for="tipe_kognitif">Tipe Kognitif</label>
                    <select name="tipe_kognitif" id="tipe_kognitif" class="form-control">
                        <option value="ingatan" <?= set_select('tipe_kognitif', 'ingatan') ?>>Ingatan</option>
                        <option value="paham" <?= set_select('tipe_kognitif', 'paham', TRUE) ?>>Pemahaman</option>
                        <option value="aplikasi" <?= set_select('tipe_kognitif', 'aplikasi') ?>>Aplikasi</option>
                        <option value="analisis" <?= set_select('tipe_kognitif', 'analisis') ?>>Analisis</option>
                        <option value="evaluasi" <?= set_select('tipe_kognitif', 'evaluasi') ?>>Evaluasi</option>
                        <option value="kreasi" <?= set_select('tipe_kognitif', 'kreasi') ?>>Kreasi</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Soal</button>
                <a href="<?= site_url('guru/bank_soal') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>