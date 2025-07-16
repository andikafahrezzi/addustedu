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
            
            <h2><?= $materi->nama_mapel ?> - Kelas <?= $materi->nama_kelas ?></h2>
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
<!-- Forum Diskusi -->
<div class="discussion-forum">
    <h3><i class="fa-regular fa fa-comments"></i> Forum Diskusi</h3>
    
    <!-- Form Komentar Utama -->
    <form class="comment-form" method="POST" action="<?= base_url('siswa/tambah_komentar') ?>">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" 
        value="<?= $this->security->get_csrf_hash() ?>">
        <input type="hidden" name="id_pertemuan" value="<?= $id_pertemuan ?>">
    
    <textarea name="komentar" placeholder="Tulis komentar atau pertanyaan..." required></textarea>
    <button type="submit"><i class="fa fa-paper-plane"></i> Kirim</button>
    </form>

    
    <!-- Daftar Komentar -->
    <div id="komentar-list">
        <?php if (!empty($forum)): ?>
            <?php foreach ($forum as $komentar): ?>
                <?php $this->load->view('materi/partials/comment_replies', [
                    'komentar' => $komentar,
                    'materi' => $materi,
                    'current_nis' => $current_nis,
                    'level' => 0
                ]); ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Belum ada komentar untuk materi ini.</div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->

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
    
    // Batal reply/edit
    $(document).on('click', '.btn-cancel-reply, .btn-cancel-edit', function() {
        $(this).closest('.reply-form, .edit-form').hide();
    });
    
    // Konfirmasi hapus
    $(document).on('click', '.btn-hapus', function() {
        var id = $(this).data('id');
        $('#btn-delete-confirm').attr('href', '<?= base_url('siswa/hapus_komentar/') ?>' + id);
        $('#confirmDeleteModal').modal('show');
    });
});
</script>
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
                        <?php echo form_open_multipart('siswa/upload_tugas/'.$materi->id_pertemuan); ?>
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <input type="hidden" name="id_pertemuan" value="<?= $id_pertemuan ?>">
                                                <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger mt-2">
                                    <?= $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label>File Tugas (JPG, PNG, PDF, DOC/DOCX, max 5MB)</label>
                                <input type="file" name="file_tugas" class="form-control-file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        <?php echo form_close(); ?>
                    </div>
                    
                    <h5>Tugas</h5>
                    <?php if ($tugas_saya): ?>
                        <!-- Pastikan tidak NULL -->
                       <div class="card mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <h6><?= $tugas_saya->original_filename ?></h6>
        <small>Ukuran: <?= round($tugas_saya->file_size / 1024, 2) ?> KB</small><br>
        <small>Dikirim: <?= date('d M Y H:i', strtotime($tugas_saya->dikirim_pada)) ?></small><br>
        <small>Nilai: <?= number_format($tugas_saya->nilai) ?></small>
      </div>
      <div class="col-md-4 text-md-right text-left mt-3 mt-md-0">
        <a href="<?= base_url($tugas_saya->file_path) ?>"
           class="btn btn-sm btn-success mr-2"
           download="<?= $tugas_saya->original_filename ?>.<?= pathinfo($tugas_saya->file_path, PATHINFO_EXTENSION) ?>">
          <i class="fas fa-download"></i> Unduh
        </a>
        <a href="<?= base_url('siswa/delete_tugas/' . $tugas_saya->id) ?>"
            onclick="return confirm('Apakah kamu yakin ingin menghapus tugas ini?')"
            class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Hapus
            </a>

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

    // Toggle form reply (balas)
    $('.btn-reply').click(function() {
        var id = $(this).data('id');
        $('.reply-form').not('#reply-form-' + id).hide(); // sembunyikan form lain
        $('#reply-form-' + id).toggle();
        // juga sembunyikan edit form kalau ada
        $('#edit-form-' + id).hide();
    });

    // Batal reply
    $('.btn-cancel-reply').click(function() {
        var id = $(this).data('id');
        $('#reply-form-' + id).hide();
    });

    // Toggle form edit
    $('.btn-edit').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('.edit-form').not('#edit-form-' + id).hide(); // sembunyikan form edit lain
        $('#edit-form-' + id).toggle();
        $('#reply-form-' + id).hide();
    });

    // Batal edit
    $('.btn-cancel-edit').click(function() {
        var id = $(this).data('id');
        $('#edit-form-' + id).hide();
    });

    // Konfirmasi hapus
    $('.btn-hapus').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#btn-delete-confirm').attr('href', '<?= base_url('siswa/hapus_komentar/') ?>' + id);
        $('#confirmDeleteModal').modal('show');
    });

    // Scroll ke komentar yang baru saja dibalas atau diedit
    <?php if ($this->session->flashdata('scroll_to')): ?>
        $('html, body').animate({
            scrollTop: $('#komentar-<?= $this->session->flashdata('scroll_to') ?>').offset().top - 100
        }, 500);
    <?php endif; ?>

});
</script>

<script>
    function confirmDeletee(id) {
  Swal.fire({
    title: 'Apakah kamu yakin?',
    text: "Tugas akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '<?= base_url('siswa/delete_tugas/') ?>' + id;
    }
  });
}
</script>