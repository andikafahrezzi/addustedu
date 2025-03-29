<!-- Modern Learning View Redesign with Linearicons -->
<div class="learning-container">
    <!-- Hero Banner Section -->
    <div class="learning-hero">
        <div class="learning-hero-content">
            <h1>Selamat Belajar!</h1>
            <div class="user-profile">
                <div class="user-avatar">
                    <?php
                    $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
                    echo substr($data['user']['nama'], 0, 1);
                    ?>
                </div>
                <div class="user-info">
                    <h3><?= $user['nama'] ?></h3>
                    <p>addustedu Student</p>
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
            <div class="video-controls">
                <button onclick="document.getElementById('myvideo').play()">
                    <span class="lnr lnr-play-circle"></span> Play
                </button>
                <button onclick="document.getElementById('myvideo').pause()">
                    <span class="lnr lnr-pause"></span> Pause
                </button>
                <input type="range" id="progress-bar" min="0" max="100" value="0">
                <span id="time-display">0:00 / 0:00</span>
            </div>
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
    <div class="discussion-forum">
            <h3><span class="lnr lnr-bubble"></span> Forum Diskusi</h3>
            
            <!-- Comment Form -->
            <form class="comment-form" method="POST" action="<?= base_url('forum/tambah_komentar') ?>">
                <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
                <textarea name="komentar" placeholder="Tulis komentar atau pertanyaan..." required></textarea>
                <button type="submit"><span class="lnr lnr-paperclip"></span> Kirim</button>
            </form>
            
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                        <div class="card-body">
                                <!-- Komentar Tampilan -->
                                <?php 
function display_comments($comments, $materi_id, $level = 0, $current_nis ) {
    foreach ($comments as $comment) {
        $margin = min($level * 32, 256);
        $can_edit = ($current_nis && $current_nis == $comment->nis);
?>
        <div class="comment-card" style="margin-left: <?= $margin ?>px;" id="comment-<?= $comment->id ?>">
            <div class="comment-header">
                <div class="comment-author">
                    <span class="user-avatar">
                        <?= strtoupper(substr($comment->user, 0, 1)) ?>
                    </span>
                    <strong><?= htmlspecialchars($comment->user) ?></strong>
                </div>
                <span class="comment-date">
                    <?= date('d M Y H:i', strtotime($comment->created_at)) ?>
                    <?php if ($comment->updated_at): ?>
                        <small>(diedit)</small>
                    <?php endif; ?>
                </span>
            </div>
            
            <div id="comment-display-<?= $comment->id ?>" class="comment-content">
                <p><?= nl2br(htmlspecialchars($comment->komentar)) ?></p>
                <button class="btn-action reply-btn" onclick="toggleReplyForm(<?= $comment->id ?>)">
                                            <i class="fas fa-reply"></i> Balas
                                        </button>
                <?php if ($can_edit): ?>
                    <div class="comment-actions">
                        <button class="btn btn-sm btn-outline-primary edit-btn" 
                                onclick="toggleEditForm(<?= $comment->id ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        
                        <button class="btn btn-sm btn-outline-danger delete-btn" 
                                onclick="confirmDelete(<?= $comment->id ?>)">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Reply Form -->
            <div id="reply-form-<?= $comment->id ?>" class="reply-form" style="display: none;">
                                        <form method="POST" action="<?= base_url('forum/tambah_komentar') ?>">
                                            <input type="hidden" name="materi_id" value="<?= $materi_id ?>">
                                            <input type="hidden" name="parent_id" value="<?= $comment->id ?>">
                                            
                                            <div class="form-group mb-3">
                                                <textarea class="form-control" name="komentar" rows="3" placeholder="Tulis balasan Anda..." required></textarea>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="submit" class="btn-submit">
                                                    <i class="fas fa-paper-plane"></i> Kirim
                                                </button>
                                                <button type="button" class="btn-cancel" onclick="toggleReplyForm(<?= $comment->id ?>)">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
            
            <?php if ($can_edit): ?>
                <div id="edit-form-<?= $comment->id ?>" class="edit-form mt-3" style="display:none">
                    <form method="POST" action="<?= base_url('forum/edit_komentar') ?>">
                        <input type="hidden" name="comment_id" value="<?= $comment->id ?>">
                        <div class="form-group">
                            <textarea class="form-control" name="komentar" rows="3" required><?= 
                                htmlspecialchars($comment->komentar) 
                            ?></textarea>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" 
                                    onclick="toggleEditForm(<?= $comment->id ?>)">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
            
            <!-- Form Balasan -->
            <div id="reply-form-<?= $comment->id ?>" class="reply-form mt-3" style="display:none">
                <!-- ... (kode form balasan tetap sama) ... -->
            </div>

            <?php if (!empty($comment->replies)): ?>
                <?php display_comments($comment->replies, $materi_id, $level + 1, $current_nis); ?>
            <?php endif; ?>
        </div>
<?php
    }
}
if (!empty($forum)) {
    display_comments($forum, $materi->id,0,  $current_nis);
} else {
    echo "<p class='mt-3'>Belum ada komentar.</p>";
}
?>

<!-- JavaScript untuk Handle Edit dan Delete -->


<!-- CSS Tambahan -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Resources -->
    <div class="learning-sidebar">
        <!-- Learning Materials -->
        <div class="resources-card">
            <h3><span class="lnr lnr-book"></span> Materi Pembelajaran</h3>
            
            <!-- Module -->
            <div class="resource-item">
                <div class="resource-icon">
                    <span class="lnr lnr-file-empty"></span>
                </div>
                <div class="resource-content">
                    <h4>Modul Pembelajaran</h4>
                    <?php 
                    $modulPath = 'assets/materi_modul/' . trim($materi->modul);
                    if (!empty($materi->modul) && file_exists(FCPATH . $modulPath)): 
                    ?>
                        <div class="resource-actions">
                            <a href="<?= base_url('assets/materi_modul/' . $materi->modul) ?>" target="_blank">
                                <span class="lnr lnr-eye"></span> Lihat
                            </a>
                            <a href="<?= base_url('assets/materi_modul/' . $materi->modul) ?>" download>
                                <span class="lnr lnr-download"></span> Unduh
                            </a>
                        </div>
                    <?php else: ?>
                        <span class="resource-unavailable">Tidak tersedia</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Assignment -->
            <div class="resource-item">
                <div class="resource-icon">
                    <span class="lnr lnr-list"></span>
                </div>
                <div class="resource-content">
                    <h4>Tugas</h4>
                    <?php if (!empty($materi->linkform)): ?>
                        <a href="<?= htmlspecialchars($materi->linkform) ?>" target="_blank">
                            <span class="lnr lnr-exit"></span> Buka Google Form
                        </a>
                    <?php else: ?>
                        <span class="resource-unavailable">Tidak tersedia</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quizzes -->
            <div class="resource-item">
                <div class="resource-icon">
                    <span class="lnr lnr-question-circle"></span>
                </div>
                <div class="resource-content">
                    <h4>Quiz</h4>
                    <?php if (!empty($quizzes)): ?>
                        <div class="quiz-list">
                            <?php foreach($quizzes as $quiz): 
                                $result = $this->Quiz_model->get_quiz_result($quiz->id, $user['nis']);
                            ?>
                            <div class="quiz-item <?= $result ? 'completed' : '' ?>">
                                <div class="quiz-info">
                                    <h5><?= $quiz->judul ?></h5>
                                    <p><?= $quiz->jumlah_soal ?> soal • <?= $quiz->waktu_pengerjaan ?> menit</p>
                                </div>
                                <div class="quiz-action">
                                    <?php if($result): ?>
                                        <?php if($result->status == 'completed'): ?>
                                            <span class="quiz-score <?= $result->score >= 70 ? 'good' : 'bad' ?>">
                                                <?= number_format($result->score, 2) ?>
                                            </span>
                                        <?php else: ?>
                                            <a href="<?= site_url('siswa/lanjutkan_quiz/'.$result->id) ?>" class="btn-continue">
                                                <span class="lnr lnr-arrow-right-circle"></span> Lanjutkan
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="<?= site_url('siswa/start_quiz/'.$quiz->id) ?>" class="btn-start">
                                            <span class="lnr lnr-play-circle"></span> Mulai
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="no-quiz">Belum ada quiz untuk materi ini</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Progress Tracker -->
        <!-- <div class="progress-tracker">
            <h3><span class="lnr lnr-chart-bars"></span> Progress Belajar</h3>
            <div class="progress-bar">
                <div class="progress" style="width: 65%"></div>
            </div>
            <div class="progress-info">
                <span>65% selesai</span>
                <span>35 menit dari 54 menit</span>
            </div>
            <div class="progress-actions">
                <button class="btn-bookmark">
                    <span class="lnr lnr-bookmark"></span> Tandai
                </button>
                <button class="btn-complete">
                    <span class="lnr lnr-checkmark-circle"></span> Tandai Selesai
                </button>
            </div>
        </div> -->
    </div>
</div>

<!-- Video Controls Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('myvideo');
    const progressBar = document.getElementById('progress-bar');
    const timeDisplay = document.getElementById('time-display');
    
    video.addEventListener('timeupdate', function() {
        const progress = (video.currentTime / video.duration) * 100;
        progressBar.value = progress;
        
        const currentTime = formatTime(video.currentTime);
        const duration = formatTime(video.duration);
        timeDisplay.textContent = `${currentTime} / ${duration}`;
    });
    
    progressBar.addEventListener('input', function() {
        const seekTime = (progressBar.value / 100) * video.duration;
        video.currentTime = seekTime;
    });
    
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }
});
</script>

<!-- Discussion Forum Script -->
<script>
// Toggle Form Edit
function toggleEditForm(commentId) {
    const displayDiv = document.getElementById(`comment-display-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);
    
    if (editForm.style.display === 'none' || !editForm.style.display) {
        displayDiv.style.display = 'none';
        editForm.style.display = 'block';
    } else {
        displayDiv.style.display = 'block';
        editForm.style.display = 'none';
    }
}

// Toggle Reply Form
function toggleReplyForm(commentId) {
    const displayDiv = document.getElementById(`comment-display-${commentId}`);
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    
    if (replyForm.style.display === 'none' || !replyForm.style.display) {
        displayDiv.style.display = 'none';
        replyForm.style.display = 'block';
    } else {
        displayDiv.style.display = 'block';
        replyForm.style.display = 'none';
    }
}

// Konfirmasi Hapus
function confirmDelete(commentId) {
    if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
        fetch(`<?= base_url('forum/hapus_komentar/') ?>${commentId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Menandai sebagai AJAX request
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Hapus elemen komentar dari DOM
                const commentElement = document.getElementById(`comment-${commentId}`);
                if (commentElement) {
                    commentElement.remove();
                }
                // Tampilkan notifikasi
                showToast('success', data.message);
            } else {
                showToast('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Terjadi kesalahan saat menghapus komentar');
            window.location.reload(); // Reload jika ada error session
        });
    }
}

// Fungsi untuk menampilkan notifikasi
function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => toast.remove(), 3000);
}
</script>

<!-- Add Linearicons CSS -->

<style>
/* Modern Learning View Styles */

</style>