<div class="learning-container">
    <!-- Hero Banner Section -->
    <div class="learning-hero">
        <div class="learning-hero-content">
            <h1>Selamat Mengajar!</h1>
            <div class="user-profile">
                <div class="user-avatar">
                    <?= substr($this->session->userdata('nama_guru'), 0, 1) ?>
                </div>
                <div class="user-info">
                    <h3><?= $this->session->userdata('nama_guru') ?></h3>
                    <p>Pengajar addustedu</p>
                </div>
            </div>
            <h2><?= $materi->nama_mapel ?> - Kelas <?= $materi->kelas ?></h2>
        </div>
        <div class="learning-hero-image">
            <img src="<?= base_url('assets/img/logou.png') ?>" alt="Learning Illustration">
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="learning-main">
        <!-- Video Player Section -->
        <div class="video-player">
            <video id="myvideo" controls>
                <source src="<?= base_url('assets/materi_video/' . $materi->video) ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Forum Diskusi -->
        <div class="discussion-forum mt-4">
            <h3><i class="fas fa-comments"></i> Forum Diskusi</h3>
            
            <!-- Form Komentar Utama -->
            <form class="comment-form mb-4" method="POST" action="<?= base_url('guru/tambah_komentar') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
                <div class="form-group">
                    <textarea name="komentar" class="form-control" rows="3" placeholder="Tulis komentar atau pertanyaan..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Kirim Komentar
                </button>
            </form>

            <!-- Daftar Komentar -->
            <div id="komentar-list">
                <?php if (!empty($forum)): ?>
                    <?php foreach ($forum as $komentar): ?>
                        <?php $this->load->view('partials/comment_item', [
                            'komentar' => $komentar,
                            'materi' => $materi,
                            'current_user' => [
                                'type' => 'guru',
                                'identifier' => $this->session->userdata('nip')
                            ],
                            'level' => 0
                        ]); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">Belum ada komentar untuk materi ini.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus komentar ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="btn-delete-confirm" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Toggle form reply
    $(document).on('click', '.btn-reply', function() {
        var id = $(this).data('id');
        $('.reply-form').hide();
        $('#reply-form-' + id).show();
    });
    
    // Toggle form edit
    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        $('.edit-form').hide();
        $('#edit-form-' + id).show();
    });
    
    // Batal reply
    $(document).on('click', '.btn-cancel-reply', function() {
        var id = $(this).data('id');
        $('#reply-form-' + id).hide();
    });
    
    // Batal edit
    $(document).on('click', '.btn-cancel-edit', function() {
        var id = $(this).data('id');
        $('#edit-form-' + id).hide();
    });
    
    // Konfirmasi hapus
    $(document).on('click', '.btn-hapus', function() {
        var id = $(this).data('id');
        $('#btn-delete-confirm').attr('href', '<?= base_url('guru/hapus_komentar/') ?>' + id);
        $('#confirmDeleteModal').modal('show');
    });
});
</script>