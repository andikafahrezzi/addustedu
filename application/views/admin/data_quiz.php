<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Management Data Quiz Ctkarya</h2>
                <hr>
                <a href="<?= base_url('admin/add_quiz') ?>" class="btn btn-success">Tambah Quiz ⭢</a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="get" action="<?= site_url('admin/data_quiz') ?>" class="mb-3">
            <div class="form-row">
                <div class="col-md-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari keyword..."
                        value="<?= $filters['keyword'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <select name="guru" class="form-control">
                        <option value="">Pilih Guru</option>
                        <?php foreach ($guru_list as $g): ?>
                            <option value="<?= $g->nip ?>" <?= ($filters['guru'] ?? '') == $g->nip ? 'selected' : '' ?>>
                                <?= $g->nama_guru ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="mapel" class="form-control">
                        <option value="">Pilih Mapel</option>
                        <?php foreach ($mapel_list as $m): ?>
                            <option value="<?= $m->id ?>" <?= ($filters['mapel'] ?? '') == $m->id ? 'selected' : '' ?>>
                                <?= $m->nama_mapel ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="kelas" class="form-control">
                        <option value="">Pilih Kelas</option>
                        <?php foreach ($kelas_list as $k): ?>
                            <option value="<?= $k->id ?>" <?= ($filters['kelas'] ?? '') == $k->id ? 'selected' : '' ?>>
                                <?= $k->nama_kelas ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="submit" value="1" class="btn btn-primary">Cari</button>
                    <a href="<?= site_url('admin/reset_search_quiz') ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Nama Guru</th>
                                    <th>Nama Mapel</th>
                                    <th>Deskripsi</th>
                                    <th>Lamanya Quiz</th>
                                    <th>Kelas</th>
                                    <th>Dibuat</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($quiz)): ?>
                                    <?php foreach ($quiz as $u): ?>
                                        <tr class="text-center">
                                            <td><?= $u->id ?></td>
                                            <td><?= $u->nama_guru ?></td>
                                            <td><?= $u->nama_mapel ?></td>
                                            <td><?= substr($u->deskripsi, 0, 15) ?>...</td>
                                            <td><?= $u->waktu_pengerjaan ?></td>
                                            <td><?= $u->nama_kelas ?></td>
                                            <td><?= $u->created_at ?></td>
                                            <td>
                                                <a href="<?= site_url('admin/kelola_quiz/' . $u->id); ?>" class="btn btn-info btn-sm">Update Soal ⭢</a>
                                                <button onclick="confirmDeleteQuiz('<?= $u->id; ?>')" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data quiz.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="mt-3">
                        <?= $pagination ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


    <!-- Start Sweetalert -->

    <?php if ($this->session->flashdata('success-edit')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Materi Telah Dirubah!',
                text: 'Selamat data berubah!',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('user-delete')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Materi Telah Dihapus!',
                text: 'Selamat data telah Dihapus!',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success-reg')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Materi Telah Ditambah!',
                text: 'Selamat data telah Ditambah!',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php endif; ?>

    <!-- End Sweetalert -->
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
        $('#deleteQuizLink').attr('href', '<?= site_url("admin/delete_quiz/"); ?>' + id);
        $('#deleteQuizModal').modal('show');
    }
</script>