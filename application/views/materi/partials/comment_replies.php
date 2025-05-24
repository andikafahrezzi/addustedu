<?php 
$is_siswa = ($komentar->user_type === 'siswa');
$margin = $level * 30; // 30px indent per level
?>
<div class="media mb-4 <?= $is_siswa ? 'siswa-komentar' : 'guru-komentar' ?>" 
     id="komentar-<?= $komentar->id ?>" style="margin-left: <?= $margin ?>px">
    <img src="<?= $is_siswa ? 
        base_url('assets/profile_picture/'.$komentar->siswa_foto) : 
        base_url('assets/profile_picture/'.$komentar->guru_foto) ?>" 
        class="mr-3 rounded-circle" width="50" 
        onerror="this.src='<?= base_url('assets/profile_picture/default.jpg') ?>'">
    <div class="media-body">
        <div class="d-flex justify-content-between">
            <h5 class="mt-0">
                <?= htmlspecialchars($komentar->user_name) ?>
                <span class="badge <?= $is_siswa ? 'badge-info' : 'badge-success' ?>">
                    <?= $is_siswa ? 'Siswa' : 'Guru' ?>
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
            
            <?php if ($is_siswa && $komentar->user_id == $current_nis): ?>
                <button class="btn btn-outline-primary btn-edit" 
                    data-id="<?= $komentar->id ?>"
                    data-komentar="<?= htmlspecialchars($komentar->komentar) ?>">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-outline-danger btn-hapus" data-id="<?= $komentar->id ?>">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            <?php endif; ?>
        </div>
        
        <!-- Form Edit -->
        <div class="edit-form mt-3" id="edit-form-<?= $komentar->id ?>" style="display:none">
            <form method="post" action="<?= base_url('siswa/edit_komentar') ?>">
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
                <button type="button" class="btn btn-secondary btn-sm btn-cancel-edit" data-id="<?= $komentar->id ?>">
                    Batal
                </button>
            </form>
        </div>
        
        <!-- Form Balasan -->
        <div class="reply-form mt-3" id="reply-form-<?= $komentar->id ?>" style="display:none">
            <form method="post" action="<?= base_url('siswa/tambah_komentar') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
                <input type="hidden" name="parent_id" value="<?= $komentar->id ?>">
                <div class="form-group">
                    <textarea name="komentar" class="form-control" rows="2" placeholder="Tulis balasan Anda..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-paper-plane"></i> Kirim
                </button>
                <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply" data-id="<?= $komentar->id ?>">
                    Batal
                </button>
            </form>
        </div>
        
        <!-- Tampilkan Balasan -->
        <?php if (!empty($komentar->replies)): ?>
            <?php foreach ($komentar->replies as $reply): ?>
                <?php $this->load->view('materi/partials/comment_replies', [
                    'komentar' => $reply,
                    'materi' => $materi,
                    'current_nis' => $current_nis,
                    'level' => $level + 1
                ]); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>