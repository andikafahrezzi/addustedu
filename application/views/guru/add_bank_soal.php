<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-success"><?= $title ?></h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="<?= site_url('guru/add_bank_soal') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <!-- Tipe Soal -->
                <div class="form-group">
                    <label for="tipe_soal">Tipe Soal *</label>
                    <select name="tipe_soal" id="tipe_soal" class="form-control" required>
                        <option value="">-- Pilih Tipe Soal --</option>
                        <option value="pilihan" <?= set_select('tipe_soal', 'pilihan') ?>>Pilihan Ganda</option>
                        <option value="essay" <?= set_select('tipe_soal', 'essay') ?>>Essay</option>
                    </select>
                    <?= form_error('tipe_soal', '<small class="text-danger">', '</small>') ?>
                </div>

                <!-- Pertanyaan -->
                <div class="form-group">
                    <label for="pertanyaan">Pertanyaan *</label>
                    <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="5" required><?= set_value('pertanyaan') ?></textarea>
                    <?= form_error('pertanyaan', '<small class="text-danger">', '</small>') ?>
                </div>
                
                <!-- Pilihan Jawaban (Hanya untuk Pilihan Ganda) -->
                <div id="pilihan-ganda-container" style="display:none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_a">Pilihan A *</label>
                                <input type="text" name="pilihan_a" id="pilihan_a" class="form-control" value="<?= set_value('pilihan_a') ?>">
                                <?= form_error('pilihan_a', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_b">Pilihan B *</label>
                                <input type="text" name="pilihan_b" id="pilihan_b" class="form-control" value="<?= set_value('pilihan_b') ?>">
                                <?= form_error('pilihan_b', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_c">Pilihan C *</label>
                                <input type="text" name="pilihan_c" id="pilihan_c" class="form-control" value="<?= set_value('pilihan_c') ?>">
                                <?= form_error('pilihan_c', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_d">Pilihan D *</label>
                                <input type="text" name="pilihan_d" id="pilihan_d" class="form-control" value="<?= set_value('pilihan_d') ?>">
                                <?= form_error('pilihan_d', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kunci Jawaban -->
                    <div class="form-group">
                        <label for="kunci_jawaban">Kunci Jawaban *</label>
                        <select name="kunci_jawaban" id="kunci_jawaban" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="A" <?= set_select('kunci_jawaban', 'A') ?>>A</option>
                            <option value="B" <?= set_select('kunci_jawaban', 'B') ?>>B</option>
                            <option value="C" <?= set_select('kunci_jawaban', 'C') ?>>C</option>
                            <option value="D" <?= set_select('kunci_jawaban', 'D') ?>>D</option>
                        </select>
                        <?= form_error('kunci_jawaban', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <!-- Mata Pelajaran -->
                <!-- Mata Pelajaran -->
<!-- Mata Pelajaran -->
<div class="form-group">
    <label for="id_mapel">Mata Pelajaran *</label>
    <select name="id_mapel" id="id_mapel" class="form-control" required>
        <option value="">-- Pilih Mata Pelajaran --</option>
        <?php foreach ($list_mapel as $mapel): ?>
            <option value="<?= $mapel->id ?>" <?= set_select('id_mapel', $mapel->id) ?>>
                <?= htmlspecialchars($mapel->nama_mapel) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?= form_error('id_mapel', '<small class="text-danger">', '</small>') ?>
</div>

                
                <!-- Tingkat Kesulitan -->
                <div class="form-group">
                    <label for="tingkat_kesulitan">Tingkat Kesulitan</label>
                    <select name="tingkat_kesulitan" id="tingkat_kesulitan" class="form-control">
                        <option value="mudah" <?= set_select('tingkat_kesulitan', 'mudah') ?>>Mudah</option>
                        <option value="sedang" <?= set_select('tingkat_kesulitan', 'sedang', TRUE) ?>>Sedang</option>
                        <option value="sulit" <?= set_select('tingkat_kesulitan', 'sulit') ?>>Sulit</option>
                    </select>
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
                
                <button type="submit" class="btn btn-success">Simpan Soal</button>
                <a href="<?= site_url('guru/bank_soal') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan/sembunyikan pilihan ganda
    function togglePilihanGanda() {
        if ($('#tipe_soal').val() === 'pilihan') {
            $('#pilihan-ganda-container').show();
            // Buat field required
            $('#pilihan-a, #pilihan-b, #pilihan-c, #pilihan-d, #kunci_jawaban').prop('required', true);
        } else {
            $('#pilihan-ganda-container').hide();
            // Hilangkan required
            $('#pilihan-a, #pilihan-b, #pilihan-c, #pilihan-d, #kunci_jawaban').prop('required', false);
        }
    }

    // Jalankan saat halaman dimuat
    togglePilihanGanda();
    
    // Jalankan saat tipe soal berubah
    $('#tipe_soal').change(function() {
        togglePilihanGanda();
    });

    // Jika ada error validasi, pastikan tampilan sesuai
    <?php if (form_error('pilihan_a') || form_error('pilihan_b') || form_error('pilihan_c') || form_error('pilihan_d') || form_error('kunci_jawaban')): ?>
        $('#tipe_soal').val('pilihan').trigger('change');
    <?php endif; ?>
});
</script>