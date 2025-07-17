
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update Quiz: <?= htmlspecialchars($quiz->judul) ?></h6>
        </div>
        <div class="card-body">
            <?php echo form_open('guru/update/'.$quiz->id); ?>
                
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger"><?= validation_errors() ?></div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Judul Quiz</label>
                    <input type="text" name="judul" class="form-control" 
                           value="<?= set_value('judul', $quiz->judul) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"><?= 
                        set_value('deskripsi', $quiz->deskripsi) ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Waktu Pengerjaan (menit)</label>
                            <input type="number" name="waktu_pengerjaan" class="form-control" 
                                   value="<?= set_value('waktu_pengerjaan', $quiz->waktu_pengerjaan) ?>" 
                                   min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Percobaan Maksimal</label>
                            <input type="number" name="attempts" class="form-control" 
                                   value="<?= set_value('attempts', $quiz->attempts) ?>" 
                                   min="1" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group form-check">
                    <input type="checkbox" name="shuffle_questions" class="form-check-input" id="shuffleCheck" 
                           <?= set_checkbox('shuffle_questions', '1', $quiz->shuffle_questions == 1) ?>>
                    <label class="form-check-label" for="shuffleCheck">Acak urutan soal</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= site_url('guru/data_quiz') ?>" class="btn btn-secondary">Batal</a>
                
            <?php echo form_close(); ?>
        </div>
    </div>
</div>