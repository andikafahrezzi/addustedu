<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buat Quiz Baru</h6>
        </div>
        <div class="card-body">
            <?php echo form_open(current_url()); ?>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Materi</label>
                    <select name="id_pertemuan" class="form-control" required>
                        <option value="">Pilih Materi</option>
                        <?php foreach ($materi_list as $materi): ?>
                            <option value="<?php echo $materi->id_pertemuan; ?>">
                            <?php echo $materi->id_pertemuan; ?>
                            <?php echo htmlspecialchars($materi->nama_kelas); ?>
                                <?php echo htmlspecialchars($materi->deskripsi); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Judul Quiz</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Waktu Pengerjaan (menit)</label>
                            <input type="number" name="waktu_pengerjaan" class="form-control" value="30" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Percobaan Maksimal</label>
                            <input type="number" name="attempts" class="form-control" value="1" min="1" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group form-check">
                    <input type="checkbox" name="shuffle_questions" class="form-check-input" id="shuffleCheck" checked>
                    <label class="form-check-label" for="shuffleCheck">Acak urutan soal</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo site_url('admin/kelola_quiz'); ?>" class="btn btn-secondary">Batal</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>