<?php 
$is_siswa = ($komentar->user_type === 'siswa');
?>
<div class="comment-card" id="komentar-<?= $komentar->id ?>" data-level="<?= $level ?>">
    <div class="comment-content">
        <!-- Avatar -->
        <img src="<?= $is_siswa ? 
            base_url('assets/profile_picture/'.$komentar->siswa_foto) : 
            base_url('assets/profile_picture/'.$komentar->guru_foto) ?>" 
            class="comment-avatar" 
            alt="<?= htmlspecialchars($komentar->user_name) ?>"
            onerror="this.src='<?= base_url('assets/profile_picture/default.jpg') ?>'">
            
        <div class="comment-body">
            <!-- Header -->
            <div class="comment-header">
                <h5 class="comment-author"><?= htmlspecialchars($komentar->user_name) ?></h5>
                <div class="comment-meta">
                    <span class="comment-badge <?= $is_siswa ? 'badge-info' : 'badge-success' ?>">
                        <?= $is_siswa ? 'Siswa' : 'Guru' ?>
                    </span>
                    <span class="comment-date">
                        <?= date('d M Y H:i', strtotime($komentar->created_at)) ?>
                        <?php if ($komentar->updated_at): ?>
                            <span class="text-muted small">(diedit)</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            
            <!-- Konten -->
            <p class="comment-text"><?= nl2br(htmlspecialchars($komentar->komentar)) ?></p>
            
            <!-- Actions -->
            <div class="comment-actions">
                <button class="comment-action btn-reply" data-id="<?= $komentar->id ?>">
                    <i class="fa fa-reply"></i> Balas
                </button>
                
                <?php if ($is_siswa && $komentar->user_id == $current_nis): ?>
                    <button class="comment-action btn-edit" 
                        data-id="<?= $komentar->id ?>"
                        data-komentar="<?= htmlspecialchars($komentar->komentar) ?>">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button class="comment-action btn-hapus" data-id="<?= $komentar->id ?>">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Form Edit -->
    <div class="edit-form" id="edit-form-<?= $komentar->id ?>" style="display:none">
        <form method="post" action="<?= base_url('siswa/edit_komentar') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <input type="hidden" name="comment_id" value="<?= $komentar->id ?>">
            <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
            <div class="form-group">
                <textarea name="komentar" class="form-control" rows="3" required><?= 
                    htmlspecialchars($komentar->komentar) 
                ?></textarea>
            </div>
            <div class="comment-actions">
                <button type="submit" class="comment-action">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <button type="button" class="comment-action btn-cancel-edit" data-id="<?= $komentar->id ?>">
                    Batal
                </button>
            </div>
        </form>
    </div>
    
    <!-- Form Balasan -->
    <div class="reply-form" id="reply-form-<?= $komentar->id ?>" style="display:none">
        <form method="post" action="<?= base_url('siswa/tambah_komentar') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <input type="hidden" name="id_pertemuan" value="<?= $id_pertemuan ?>">
            <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
            <input type="hidden" name="parent_id" value="<?= $komentar->id ?>">
            <div class="form-group">
                <textarea name="komentar" class="form-control" rows="2" placeholder="Tulis balasan Anda..." required></textarea>
            </div>
            <div class="comment-actions">
                <button type="submit" class="comment-action">
                    <i class="fa fa-paper-plane"></i> Kirim
                </button>
                <button type="button" class="comment-action btn-cancel-reply" data-id="<?= $komentar->id ?>">
                    Batal
                </button>
            </div>
        </form>
    </div>
    
    <!-- Tampilkan Balasan -->
    <?php if (!empty($komentar->replies)): ?>
        <div class="comment-replies">
            <?php foreach ($komentar->replies as $reply): ?>
                <?php $this->load->view('materi/partials/comment_replies', [
                    'komentar' => $reply,
                    'materi' => $materi,
                    'current_nis' => $current_nis,
                    'level' => $level + 1
                ]); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>