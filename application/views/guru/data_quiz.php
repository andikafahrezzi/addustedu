<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success">Daftar Quiz</h6>
            <a href="<?= base_url('guru/buat_quiz_guru') ?>" class="btn btn-success btn-sm">
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
                <?php if (!empty($quizzes_grouped)) : ?>
    <?php foreach ($quizzes_grouped as $nama_mapel => $list_quiz) : ?>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <strong>📘 Mata Pelajaran: <?= htmlspecialchars($nama_mapel) ?></strong>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Pertemuan</th>
                            <th>Judul Quiz</th>
                            <th>Deskripsi Materi</th>
                            <th>Kelas</th>
                            <th>Waktu</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($list_quiz as $quiz): ?>
                        <tr>
                            <td class="text-center">Pertemuan <?= $quiz->pertemuan_ke ?></td>
                            <td><?= htmlspecialchars($quiz->judul) ?></td>
                            <td><?= htmlspecialchars($quiz->judul_materi) ?></td>
                            <td><?= htmlspecialchars($quiz->nama_kelas) ?></td>
                            <td class="text-center"><?= $quiz->waktu_pengerjaan ?> menit</td>
                            <td><?= date('d M Y', strtotime($quiz->created_at)) ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="<?= base_url('guru/data_pesertaquiz/'.$quiz->id) ?>" class="btn btn-sm btn-primary" title="Peserta"><i class="fas fa-user"></i></a>
                                    <a href="<?= base_url('guru/edit_quiz/'.$quiz->id) ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('guru/kelola_quiz/'.$quiz->id) ?>" class="btn btn-sm btn-info" title="Kelola Soal"><i class="fas fa-newspaper"></i></a>
                                    <button onclick="confirmDeleteQuiz('<?= $quiz->id; ?>')" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="alert alert-info">Belum ada quiz yang dibuat.</div>
<?php endif; ?>

            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Quiz -->
<div class="modal fade" id="deleteQuizModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuizModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteQuizModalLabel">Konfirmasi Hapus Quiz</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus quiz ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a id="deleteQuizLink" href="#" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>


<script>
    function confirmDeleteQuiz(id) {
        $('#deleteQuizLink').attr('href', '<?= site_url("guru/delete_quiz/"); ?>' + id);
        $('#deleteQuizModal').modal('show');
    }
</script>
