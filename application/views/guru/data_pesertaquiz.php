<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peserta  Quiz</h6>
            
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
                            <th>Nis</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Status</th>
                            <th>Score</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pesertaquiz)) : ?>
                            <?php $no = 1; ?>
                            <?php foreach ($pesertaquiz as $quiz) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($quiz->siswa_id) ?></td>
                                    <td><?= htmlspecialchars($quiz->nama_siswa) ?></td>
                                    <td><?= htmlspecialchars($quiz->kelas) ?></td>
                                    <td><?= date('d M Y', strtotime($quiz->start_time)) ?></td>
                                    <td><?= date('d M Y', strtotime($quiz->end_time)) ?></td>
                                    <td><?= $quiz->status ?></td>
                                    <td><?= $quiz->score ?></td>
                                    <td>
                                        <div class="btn-group">
                                            
                                            <button onclick="confirmDeleteQuiz('<?= $quiz->id; ?>')" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
        $('#deleteQuizLink').attr('href', '<?= site_url("guru/delete_pesertaquiz/"); ?>' + id);
        $('#deleteQuizModal').modal('show');
    }
</script>
