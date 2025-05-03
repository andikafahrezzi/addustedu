    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="post" action="<?= site_url('guru/simpan_ujian') ?>">
                    <!-- Informasi Dasar Ujian -->
                    <div class="form-group">
                        <label for="nama_ujian">Nama Ujian *</label>
                        <input type="text" name="nama_ujian" id="nama_ujian" class="form-control" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="materi_id">Materi</label>
                                <select name="materi_id" id="materi_id" class="form-control">
                                    <option value="">-- Pilih Materi --</option>
                                    <?php foreach ($materi_list as $materi): ?>
                                    <option value="<?= $materi->id ?>"><?= $materi->nama_mapel ?> - <?= $materi->kelas ?> - <?= $materi->deskripsi ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="durasi">Durasi (menit) *</label>
                                <input type="number" name="durasi" id="durasi" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai *</label>
                                <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai *</label>
                                <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pilihan Sumber Soal -->
                    <div class="form-group">
                        <label>Sumber Soal *</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sumber_soal" id="bank_soal" value="bank_soal" checked>
                            <label class="form-check-label" for="bank_soal">
                                Ambil dari Bank Soal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sumber_soal" id="manual" value="manual">
                            <label class="form-check-label" for="manual">
                                Buat Soal Manual
                            </label>
                        </div>
                    </div>
                    
                    <!-- Daftar Soal dari Bank Soal -->
                    <div id="bank-soal-container">
                        <div class="form-group">
                            <label>Pilih Soal dari Bank Soal</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%">Pilih</th>
                                            <th>Pertanyaan</th>
                                            <th>Tipe</th>
                                            <th>Tingkat Kesulitan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bank_soal as $soal): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="soal_ids[]" value="<?= $soal->id_soal ?>">
                                            </td>
                                            <td><?= character_limiter($soal->pertanyaan, 100) ?></td>
                                            <td><?= $soal->tipe_soal == 'pilihan' ? 'Pilihan Ganda' : 'Essay' ?></td>
                                            <td><?= ucfirst($soal->tingkat_kesulitan) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Container untuk soal manual (bisa dikembangkan) -->
                    <div id="manual-soal-container" style="display:none;">
                        <div class="alert alert-info">
                            Untuk membuat soal manual, silahkan tambahkan soal setelah ujian dibuat.
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan Ujian</button>
                    <a href="<?= site_url('guru/tampilkan_ujian') ?>" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Toggle tampilan sumber soal
        $('input[name="sumber_soal"]').change(function() {
            if ($(this).val() == 'bank_soal') {
                $('#bank-soal-container').show();
                $('#manual-soal-container').hide();
            } else {
                $('#bank-soal-container').hide();
                $('#manual-soal-container').show();
            }
        });
    });
    </script>