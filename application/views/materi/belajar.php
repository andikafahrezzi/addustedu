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
            <h3><i class="fa-regular fa fa-comments"></i> Forum Diskusi</h3>
            
            <!-- Comment Form -->
            <form class="comment-form" method="POST" action="<?= base_url('forum/tambah_komentar') ?>">
                <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <textarea name="komentar" placeholder="Tulis komentar atau pertanyaan..." required></textarea>
                <button type="submit"><i class="fa-regular fa fa-paper-plane"></i> Kirim</button>
            </form>
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php 
                            function display_comments($comments, $materi_id, $level = 0, $current_nis) {
                                $ci =& get_instance();
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
                                        <i class="fas fa fa-reply"></i> Balas
                                    </button>
                                    <?php if ($can_edit): ?>
                                        <div class="comment-actions">
                                            <button class="btn edit-btn" onclick="toggleEditForm(<?= $comment->id ?>)">
                                                <i class="fas fa fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-btn" onclick="confirmDelete(<?= $comment->id ?>)">
                                                <i class="fas fa fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Reply Form -->
                                <div id="reply-form-<?= $comment->id ?>" class="reply-form" style="display: none;">
                                    <form method="POST" action="<?= base_url('forum/tambah_komentar') ?>">
                                        <input type="hidden" name="materi_id" value="<?= $materi_id ?>">
                                        <input type="hidden" name="parent_id" value="<?= $comment->id ?>">
                                        <input type="hidden" name="<?= $ci->security->get_csrf_token_name() ?>" value="<?= $ci->security->get_csrf_hash() ?>">
                                        <div class="form-group mb-3">
                                            <textarea class="form-control" name="komentar" rows="3" placeholder="Tulis balasan Anda..." required></textarea>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn-submit">
                                                <i class="fas fa fa-paper-plane"></i> Kirim
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
                                        <input type="hidden" name="<?= $ci->security->get_csrf_token_name() ?>" value="<?= $ci->security->get_csrf_hash() ?>">
                                        <input type="hidden" name="comment_id" value="<?= $comment->id ?>">
                                        <div class="form-group">
                                            <textarea class="form-control" name="komentar" rows="3" required><?= 
                                                htmlspecialchars($comment->komentar) 
                                            ?></textarea>
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa fa-save"></i> Simpan
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEditForm(<?= $comment->id ?>)">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($comment->replies)): ?>
                                    <?php display_comments($comment->replies, $materi_id, $level + 1, $current_nis); ?>
                                <?php endif; ?>
                            </div>
                            <?php
                                }
                            }
                            
                            if (!empty($forum)) {
                                display_comments($forum, $materi->id, 0, $current_nis);
                            } else {
                                echo "<p class='mt-3'>Belum ada komentar.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Resources -->
    <div class="learning-sidebar">
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
            
            <!-- Assignment -->
            <div class="resource-item">
                <div class="resource-icon">
                    <span class="lnr lnr lnr-link"></span>
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
            
            <!-- Upload Tugas -->
            <div class="resource-item">
                <div class="resource-icon">
                    <span class="lnr lnr-pushpin"></span>
                </div>
                <div class="resource-content">
                    <h4>Upload Tugas</h4>
                    <div class="upload-section">
                        <?php echo form_open_multipart('siswa/upload_tugas/'.$materi->id); ?>
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <div class="form-group">
                                <label>File Tugas (JPG, PNG, PDF, DOC/DOCX, max 5MB)</label>
                                <input type="file" name="file_tugas" class="form-control-file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        <?php echo form_close(); ?>
                    </div>
                    
                    <h5>Tugas</h5>
                    <?php if ($tugas_saya): ?>
                        <div class="card mb-7">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6><?= $tugas_saya->original_filename ?></h6>
                                        <small>Ukuran: <?= round($tugas_saya->file_size/1024, 2) ?> KB</small>
                                        <small>| Dikirim: <?= date('d M Y H:i', strtotime($tugas_saya->dikirim_pada)) ?></small>
                                        <small>| Nilai: <?= number_format($tugas_saya->nilai) ?></small>
                                    </div>
                                    <div>
                                        <a href="<?= base_url($tugas_saya->file_path) ?>" 
                                           class="btn btn-sm btn-success" 
                                           download="<?= $tugas_saya->original_filename ?>.<?= pathinfo($tugas_saya->file_path, PATHINFO_EXTENSION) ?>">
                                            <i class="fas fa fa-download"></i> Unduh
                                        </a>
                                        <button onclick="confirmDelete(<?= $tugas_saya->id ?>)" 
                                                class="btn btn-sm btn-danger">
                                            <i class="fas fa fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>Belum ada tugas terkirim</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
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