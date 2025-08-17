
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
            <h2><?= $materi->nama_mapel ?> - Kelas <?= $materi->nama_kelas ?></h2>
        </div>
        <div class="learning-hero-image">
            <img src="<?= base_url('assets/img/logou.png') ?>" alt="Learning Illustration">
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="learning-main">
        <!-- Video Player Section -->
<!-- REPLACE ONLY the video container in your existing code -->
<div class="learning-main">
    <!-- New Video Wrapper -->
    <!-- REPLACE JUST THE VIDEO SECTION in your existing code -->
<div class="learning-main">
    <!-- Video Fix Container -->
    <div class="video-final-fix" style="width:100%;height:0;padding-bottom:56.25%;position:relative;">
        <?php if (!empty($materi->video)): ?>
            <iframe 
                src="<?= htmlspecialchars($materi->video) ?>" 
                style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;"
                title="Video Pembelajaran"
                allowfullscreen
            ></iframe>
        <?php else: ?>
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#000;color:white;">
                <i class="fas fa-video-slash" style="font-size:2rem;"></i>
                <p>Video tidak tersedia</p>
            </div>
        <?php endif; ?>
    </div>
    
    

        <!-- Forum Diskusi -->
        <div class="discussion-forum mt-4">
            <h3><i class="fas fa-comments"></i> Forum Diskusi</h3>
            <!-- Form Komentar Utama -->
            <form class="comment-form mb-4" method="POST" action="<?= base_url('guru/tambah_komentar') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <input type="hidden" name="id_pertemuan" value="<?= $materi->id_pertemuan ?>">
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
<style>
/* Global Styles */
    .learning-container {
        font-family: 'Poppins', sans-serif;
        color: #333;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9fafb;
    }

    /* Hero Banner Section */
    .learning-hero {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 12px;
        padding: 30px;
        color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .learning-hero-content {
        flex: 1;
    }

    .learning-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .learning-hero h2 {
        font-size: 1.5rem;
        font-weight: 500;
        margin-top: 20px;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 8px 15px;
        border-radius: 20px;
        display: inline-block;
    }

    .learning-hero-image img {
        height: 180px;
        opacity: 0.9;
        transition: transform 0.3s ease;
    }

    .learning-hero-image img:hover {
        transform: scale(1.05);
    }

    /* User Profile */
    .user-profile {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        background-color: #fff;
        color: #4f46e5;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        font-weight: bold;
        margin-right: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .user-info h3 {
        font-size: 1.3rem;
        margin: 0;
        font-weight: 600;
    }

    .user-info p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    /* Video Player Section */
    .video-player {
        background-color: #000;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .video-player video {
        width: 100%;
        display: block;
    }

    /* Discussion Forum */
    .discussion-forum {
        background-color: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .discussion-forum h3 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #4f46e5;
        display: flex;
        align-items: center;
    }

    .discussion-forum h3 i {
        margin-right: 10px;
    }

    /* Comment Form */
    .comment-form {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .comment-form textarea {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px;
        resize: vertical;
        min-height: 100px;
        transition: border-color 0.3s ease;
    }

    .comment-form textarea:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .comment-form .btn-primary {
        background-color: #4f46e5;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .comment-form .btn-primary:hover {
        background-color: #4338ca;
    }

    .comment-form .btn-primary i {
        margin-right: 8px;
    }

    /* Comments List */
    #komentar-list {
        margin-top: 20px;
    }

    /* Alert */
    .alert-info {
        background-color: #e0f2fe;
        color: #0369a1;
        border-radius: 8px;
        padding: 15px;
        border-left: 4px solid #0369a1;
    }

    /* Modal */
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-header {
        background-color: #4f46e5;
        color: white;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 600;
    }

    .close {
        color: white;
        opacity: 0.8;
    }

    .close:hover {
        color: white;
        opacity: 1;
    }

    .modal-footer .btn-secondary {
        background-color: #e2e8f0;
        color: #4a5568;
        border: none;
        border-radius: 8px;
    }

    .modal-footer .btn-danger {
        background-color: #ef4444;
        border: none;
        border-radius: 8px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .learning-hero {
            flex-direction: column;
            text-align: center;
        }
        
        .learning-hero-image {
            margin-top: 20px;
        }
        
        .user-profile {
            justify-content: center;
        }
        
        .learning-hero h2 {
            margin-top: 15px;
        }
    }
</style>