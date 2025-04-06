<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Quiz</h6>
            <a href="<?= base_url('guru/buat_quiz_guru') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Buat Quiz Baru
            </a>
        </div>
        <div class="card-body">
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Quiz</th>
                            <th>Materi</th>
                            <th>Kelas</th>
                            <th>Waktu (menit)</th>
                            <th>Percobaan</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($quizzes)) : ?>
                            <?php $no = 1; ?>
                            <?php foreach ($quizzes as $quiz) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($quiz->judul) ?></td>
                                    <td><?= htmlspecialchars($quiz->judul_materi) ?></td>
                                    <td><?= htmlspecialchars($quiz->kelas) ?></td>
                                    <td><?= $quiz->waktu_pengerjaan ?></td>
                                    <td><?= $quiz->attempts ?></td>
                                    <td><?= date('d M Y', strtotime($quiz->created_at)) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('guru/edit/'.$quiz->id) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="confirmDelete('<?= $quiz->id ?>')" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <a href="<?= base_url('guru/kelola_quiz/'.$quiz->id) ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-question"></i> Soal
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada quiz yang dibuat</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(quizId) {
    if (confirm('Apakah Anda yakin ingin menghapus quiz ini? Semua soal dan jawaban terkait juga akan dihapus.')) {
        window.location.href = '<?= base_url("quiz/delete/") ?>' + quizId;
    }
}
</script>