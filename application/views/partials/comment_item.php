<?php 
$is_guru = ($komentar->user_type === 'guru');
$margin = $level * 30; // 30px indent per level
$can_edit = isset($current_user) && $this->Forum_model->can_edit_comment(
    $komentar->id, 
    $current_user['type'], 
    $current_user['identifier']
);
?>
<div class="media mb-4 <?= $is_guru ? 'guru-komentar' : 'siswa-komentar' ?>" 
     id="komentar-<?= $komentar->id ?>" style="margin-left: <?= $margin ?>px">
    <img src="<?= $is_guru ? 
        base_url('assets/profile_picture/'.$komentar->guru_foto) : 
        base_url('assets/profile_picture/'.$komentar->siswa_foto) ?>" 
        class="mr-3 rounded-circle" width="50" 
        onerror="this.src='<?= base_url('assets/profile_picture/default.jpg') ?>'">
    <div class="media-body">
        <div class="d-flex justify-content-between">
            <h5 class="mt-0">
                <?= htmlspecialchars($komentar->user_name) ?>
                <span class="badge <?= $is_guru ? 'badge-success' : 'badge-info' ?>">
                    <?= $is_guru ? 'Guru' : 'Siswa' ?>
                </span>
            </h5>
            <small class="text-muted">
                <?= date('d M Y H:i', strtotime($komentar->created_at)) ?>
                <?php if ($komentar->updated_at): ?>
                    <span class="text-info">(diedit)</span>
                <?php endif; ?>
            </small>
        </div>
        <p><?= nl2br(htmlspecialchars($komentar->komentar)) ?></p>
        
        <!-- Tombol Aksi -->
        <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-secondary btn-reply" data-id="<?= $komentar->id ?>">
                <i class="fas fa-reply"></i> Balas
            </button>
            
            <?php if ($can_edit): ?>
                <button class="btn btn-outline-primary btn-edit" 
                    data-id="<?= $komentar->id ?>"
                    data-komentar="<?= htmlspecialchars($komentar->komentar) ?>">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-outline-danger btn-hapus" 
                    data-id="<?= $komentar->id ?>">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            <?php endif; ?>
        </div>
        
        <!-- Form Edit -->
        <div class="edit-form mt-3" id="edit-form-<?= $komentar->id ?>" style="display:none">
            <form method="post" action="<?= base_url('guru/edit_komentar') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" name="comment_id" value="<?= $komentar->id ?>">
                <div class="form-group">
                    <textarea name="komentar" class="form-control" rows="3" required><?= 
                        htmlspecialchars($komentar->komentar) 
                    ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-secondary btn-sm btn-cancel-edit" 
                    data-id="<?= $komentar->id ?>">
                    Batal
                </button>
            </form>
        </div>
        
        <!-- Form Balasan -->
        <div class="reply-form mt-3" id="reply-form-<?= $komentar->id ?>" style="display:none">
            <form method="post" action="<?= base_url('guru/tambah_komentar') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
                <input type="hidden" name="parent_id" value="<?= $komentar->id ?>">
                <div class="form-group">
                    <textarea name="komentar" class="form-control" rows="2" 
                        placeholder="Tulis balasan Anda..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-paper-plane"></i> Kirim
                </button>
                <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply" 
                    data-id="<?= $komentar->id ?>">
                    Batal
                </button>
            </form>
        </div>
        
        <!-- Tampilkan Balasan -->
        <?php if (!empty($komentar->replies)): ?>
            <?php foreach ($komentar->replies as $reply): ?>
                <?php $this->load->view('partials/comment_item', [
                    'komentar' => $reply,
                    'materi' => $materi,
                    'current_user' => $current_user,
                    'level' => $level + 1
                ]); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>