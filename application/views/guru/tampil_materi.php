<!-- Modern Learning View Redesign with Linearicons -->
<div class="learning-container">
    <!-- Hero Banner Section -->
    <div class="learning-hero">
        <div class="learning-hero-content">
            <h1>Selamat Belajar!</h1>
            <div class="user-profile">
                <div class="user-avatar">
                    
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

        <!-- Course Description -->
        <div class="course-description">
            <div class="instructor-info">
                <div class="instructor-avatar">
                    <?= substr($materi->nama_guru, 0, 1) ?>
                </div>
                <div>
                    <h4><?= $materi->nama_guru ?></h4>
                    <p>Pengajar</p>
                </div>
            </div>
            <h3><?= $materi->nama_mapel ?></h3>
            <div class="course-content">
                <?= nl2br($materi->deskripsi) ?>
            </div>
        </div>

        <!-- Discussion Forum -->
        <!-- application/views/guru/forum_diskusi.php -->
<!-- Di view siswa/guru tampil_materi.php -->
<div class="forum-discussion">
    <?php if (!empty($forum)): ?>
        <?php foreach($forum as $komentar): ?>
            <?php if (is_object($komentar) && property_exists($komentar, 'user_type')): ?>
                <div class="comment <?= $komentar->user_type === 'guru' ? 'teacher-comment' : 'student-comment' ?>">
                    <div class="comment-header">
                        <span class="user-avatar">
                            <?= isset($komentar->user_name) ? strtoupper(substr($komentar->user_name, 0, 1)) : '?' ?>
                        </span>
                        <strong><?= isset($komentar->user_name) ? htmlspecialchars($komentar->user_name) : 'Unknown User' ?></strong>
                        <span class="user-badge <?= $komentar->user_type ?>">
                            <?= $komentar->user_type === 'guru' ? 'Guru' : 'Siswa' ?>
                        </span>
                        <small>
                            <?= isset($komentar->created_at) ? date('d M Y H:i', strtotime($komentar->created_at)) : '' ?>
                        </small>
                        
                        <?php if(isset($current_user) && $this->Forum_model->can_edit_comment(
                            $komentar->id, 
                            $current_user['type'], 
                            $current_user['identifier']
                        )): ?>
                            <div class="comment-actions">
                                <button class="btn-edit" data-id="<?= $komentar->id ?>">Edit</button>
                                <button class="btn-delete" data-id="<?= $komentar->id ?>">Hapus</button>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="comment-content">
                        <?= isset($komentar->komentar) ? nl2br(htmlspecialchars($komentar->komentar)) : '' ?>
                    </div>
                    
                    <!-- Form balasan -->
                    <form class="reply-form" method="post" action="<?= site_url('guru/tambah_komentar') ?>">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                        <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
                        <input type="hidden" name="parent_id" value="<?= $komentar->id ?>">
                        <textarea name="komentar" placeholder="Tulis balasan..."></textarea>
                        <button type="submit">Kirim</button>
                    </form>
                    
                    <!-- Tampilkan balasan -->
                    <?php if(!empty($komentar->replies)): ?>
                        <div class="replies">
                            <?php foreach($komentar->replies as $reply): ?>
                                <?php if (is_object($reply)): ?>
                                    <!-- Tampilkan balasan dengan struktur serupa -->
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-comments">Belum ada komentar untuk materi ini.</p>
    <?php endif; ?>
</div>

    </div>

    <!-- Sidebar Resources -->
    
</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus tugas ini? Anda bisa mengupload ulang setelah menghapus.')) {
        window.location.href = '<?= site_url("siswa/delete_tugas/") ?>' + id;
    }
}

function toggleReplyForm(commentId) {
    var form = document.getElementById('reply-form-' + commentId);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function toggleEditForm(commentId) {
    var display = document.getElementById('comment-display-' + commentId);
    var form = document.getElementById('edit-form-' + commentId);
    
    if (form.style.display === 'none') {
        display.style.display = 'none';
        form.style.display = 'block';
    } else {
        display.style.display = 'block';
        form.style.display = 'none';
    }
}
</script>

<script>
$(document).ready(function() {
    // Toggle form edit
    $('.edit-komentar').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#edit-form-' + id).show();
        $(this).closest('.card-body').find('.komentar-content').hide();
    });
    
    $('.cancel-edit').click(function() {
        var id = $(this).data('id');
        $('#edit-form-' + id).hide();
        $(this).closest('.card-body').find('.komentar-content').show();
    });
    
    // Toggle form balasan
    $('.toggle-reply').click(function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $(target).toggle();
    });
    
    $('.cancel-reply').click(function() {
        var target = $(this).data('target');
        $(target).hide();
    });
});
</script>