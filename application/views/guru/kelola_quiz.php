
<div class="container mt-4">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4>
                <i class="fas fa-edit mr-2"></i>
                Kelola Quiz: <?= $quiz->judul ?>
            </h4>
        </div>
        
        <div class="card-body">
            <!-- Form Tambah Soal -->
            <div class="mb-5">
                <h5><i class="fas fa-plus-circle mr-2"></i>Tambah Soal Baru</h5>
                <form method="post" action="">
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea name="pertanyaan" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Soal</label>
                                <select name="tipe" class="form-control" id="tipeSoal" required>
                                    <option value="pilihan">Pilihan Ganda</option>
                                    <option value="essay">Essay</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Poin</label>
                                <input type="number" name="poin" class="form-control" value="1" min="1" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Opsi untuk pilihan ganda -->
                    <div id="opsiPilihan">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Opsi A</label>
                                    <input type="text" name="opsi_a" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Opsi B</label>
                                    <input type="text" name="opsi_b" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Opsi C</label>
                                    <input type="text" name="opsi_c" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Opsi D</label>
                                    <input type="text" name="opsi_d" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jawaban Benar</label>
                            <select name="jawaban" class="form-control">
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Soal
                    </button>
                </form>
            </div>
            
            <!-- Daftar Soal -->
            <hr>
            <h5><i class="fas fa-list-ol mr-2"></i>Daftar Soal</h5>
            
            <?php if(empty($quiz->questions)): ?>
                <div class="alert alert-info">
                    Belum ada soal untuk quiz ini
                </div>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach($quiz->questions as $index => $soal): ?>
                    <div class="list-group-item mb-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">
                                <span class="badge badge-primary mr-2"><?= $index+1 ?></span>
                                <?= $soal->pertanyaan ?>
                                <small class="text-muted">(<?= strtoupper($soal->tipe) ?> - <?= $soal->poin ?> poin)</small>
                            </h6>
                            <div>
                                <a href="<?= site_url('admin/hapus_soal/'.$soal->id.'/'.$quiz->id) ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Hapus soal ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        
                        <?php if($soal->tipe == 'pilihan'): ?>
                        <div class="ml-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled 
                                       <?= $soal->jawaban == 'a' ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    A. <?= $soal->opsi_a ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled 
                                       <?= $soal->jawaban == 'b' ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    B. <?= $soal->opsi_b ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled 
                                       <?= $soal->jawaban == 'c' ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    C. <?= $soal->opsi_c ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled 
                                       <?= $soal->jawaban == 'd' ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    D. <?= $soal->opsi_d ?>
                                </label>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Sembunyikan opsi pilihan jika tipe soal essay
document.getElementById('tipeSoal').addEventListener('change', function() {
    const opsiDiv = document.getElementById('opsiPilihan');
    if(this.value === 'essay') {
        opsiDiv.style.display = 'none';
    } else {
        opsiDiv.style.display = 'block';
    }
});
</script>