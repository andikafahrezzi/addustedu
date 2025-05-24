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
        <!-- Bagian Forum Diskusi -->
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-comments"></i> Forum Diskusi</h4>
    </div>
    <div class="card-body">
        <!-- Form Komentar Utama -->
        <form id="form-komentar" method="post" action="<?= base_url('siswa/tambah_komentar') ?>">
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
            <div class="form-group">
                <textarea name="komentar" class="form-control" rows="3" 
                    placeholder="Tulis komentar atau pertanyaan..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Kirim Komentar
            </button>
        </form>

        <hr>

        <!-- Daftar Komentar -->
        <div id="komentar-list">
            <?php if (!empty($forum)): ?>
                <?php foreach ($forum as $komentar): ?>
                    <?php $is_siswa = ($komentar->user_type === 'siswa'); ?>
                    <div class="media mb-4 <?= $is_siswa ? 'siswa-komentar' : 'guru-komentar' ?>" 
                        id="komentar-<?= $komentar->id ?>">
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
                                <button class="btn btn-outline-secondary btn-reply" 
                                    data-id="<?= $komentar->id ?>">
                                    <i class="fas fa-reply"></i> Balas
                                </button>
                                
                                <?php if ($is_siswa && $komentar->user_id == $current_nis): ?>
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
                            
                            <!-- Form Edit (tersembunyi) -->
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
                                    <button type="button" class="btn btn-secondary btn-sm btn-cancel-edit" 
                                        data-id="<?= $komentar->id ?>">
                                        Batal
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Form Balasan (tersembunyi) -->
                            <div class="reply-form mt-3" id="reply-form-<?= $komentar->id ?>" style="display:none">
                                <form method="post" action="<?= base_url('siswa/tambah_komentar') ?>">
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
                                <div class="mt-3 ml-5">
                                    <?php foreach ($komentar->replies as $reply): ?>
                                        <?php $is_siswa_reply = ($reply->user_type === 'siswa'); ?>
                                        <div class="media mt-3 <?= $is_siswa_reply ? 'siswa-komentar' : 'guru-komentar' ?>">
                                            <img src="<?= base_url('assets/profile_picture/' . 
        ($is_siswa_reply 
            ? (!empty($reply->siswa_foto) ? $reply->siswa_foto : 'default.jpg') 
            : (!empty($reply->guru_foto) ? $reply->guru_foto : 'default.jpg')
        )) ?>" 
    class="mr-3 rounded-circle" 
    width="40"
    onerror="this.src='<?= base_url('assets/profile_picture/default.jpg') ?>'">

                                            <div class="media-body">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="mt-0">
                                                        <?= htmlspecialchars($reply->user_name) ?>
                                                        <span class="badge <?= $is_siswa_reply ? 'badge-info' : 'badge-success' ?>">
                                                            <?= $is_siswa_reply ? 'Siswa' : 'Guru' ?>
                                                        </span>
                                                    </h6>
                                                    <small class="text-muted">
                                                        <?= date('d M Y H:i', strtotime($reply->created_at)) ?>
                                                        <?php if ($reply->updated_at): ?>
                                                            <span class="text-info">(diedit)</span>
                                                        <?php endif; ?>
                                                    </small>
                                                </div>
                                                <p><?= nl2br(htmlspecialchars($reply->komentar)) ?></p>
                                                
                                                <?php if ($is_siswa_reply && $reply->user_id == $current_nis): ?>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary btn-edit" 
                                                            data-id="<?= $reply->id ?>"
                                                            data-komentar="<?= htmlspecialchars($reply->komentar) ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-hapus" 
                                                            data-id="<?= $reply->id ?>">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </div>
                                                    
                                                    <!-- Form Edit untuk Balasan -->
                                                    <div class="edit-form mt-2" id="edit-form-<?= $reply->id ?>" style="display:none">
                                                        <form method="post" action="<?= base_url('siswa/edit_komentar') ?>">
                                                                                                                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                                                        <input type="hidden" name="comment_id" value="<?= $reply->id ?>">
                                                            <div class="form-group">
                                                                <textarea name="komentar" class="form-control" rows="2" required><?= 
                                                                    htmlspecialchars($reply->komentar) 
                                                                ?></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-save"></i> Simpan
                                                            </button>
                                                            <button type="button" class="btn btn-secondary btn-sm btn-cancel-edit" 
                                                                data-id="<?= $reply->id ?>">
                                                                Batal
                                                            </button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">Belum ada komentar untuk materi ini.</div>
            <?php endif; ?>
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
$(document).ready(function() {
    // Toggle form balasan
    $('.btn-reply').click(function(e) {
        e.preventDefault();
        var commentId = $(this).data('id');
        $('#reply-form-' + commentId).toggle();
        $('#edit-form-' + commentId).hide();
    });
    
    // Toggle form edit
    $('.btn-edit').click(function(e) {
        e.preventDefault();
        var commentId = $(this).data('id');
        $('#edit-form-' + commentId).toggle();
        $('#reply-form-' + commentId).hide();
    });
    
    // Batal edit
    $('.btn-cancel-edit').click(function() {
        var commentId = $(this).data('id');
        $('#edit-form-' + commentId).hide();
    });
    
    // Batal balas
    $('.btn-cancel-reply').click(function() {
        var commentId = $(this).data('id');
        $('#reply-form-' + commentId).hide();
    });
    
    // Konfirmasi hapus
    $('.btn-hapus').click(function(e) {
        e.preventDefault();
        var commentId = $(this).data('id');
        $('#btn-delete-confirm').attr('href', '<?= base_url('siswa/hapus_komentar/') ?>' + commentId);
        $('#confirmDeleteModal').modal('show');
    });
    
    // Scroll ke komentar yang baru saja dibalas/diedit
    <?php if ($this->session->flashdata('scroll_to')): ?>
        $('html, body').animate({
            scrollTop: $('#komentar-<?= $this->session->flashdata('scroll_to') ?>').offset().top - 100
        }, 500);
    <?php endif; ?>
});
</script>

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