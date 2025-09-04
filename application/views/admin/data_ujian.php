<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Management Data Ujian Ctkarya</h2>
                <hr>
                <p class="card-text">After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction.</p>
            </div>
        </div>

        <!-- SEARCH FORM -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?= site_url('admin/data_ujian'); ?>" method="get" class="form-inline">
                    <input type="text" name="keyword" class="form-control mr-2 mb-2"
                           placeholder="Cari nama ujian, guru, mapel, atau kelas..."
                           value="<?= isset($filters['keyword']) ? html_escape($filters['keyword']) : ''; ?>">
                    
                    <select name="guru" class="form-control mr-2 mb-2">
                        <option value="">-- Semua Guru --</option>
                        <?php foreach ($guru_list as $guru): ?>
                            <option value="<?= $guru->nip; ?>"
                                <?= (isset($filters['guru']) && $filters['guru'] == $guru->nip) ? 'selected' : ''; ?>>
                                <?= $guru->nama_guru; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="mapel" class="form-control mr-2 mb-2">
                        <option value="">-- Semua Mapel --</option>
                        <?php foreach ($mapel_list as $mapel): ?>
                            <option value="<?= $mapel->id; ?>"
                                <?= (isset($filters['mapel']) && $filters['mapel'] == $mapel->id) ? 'selected' : ''; ?>>
                                <?= $mapel->nama_mapel; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="kelas" class="form-control mr-2 mb-2">
                        <option value="">-- Semua Kelas --</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                            <option value="<?= $kelas->id; ?>"
                                <?= (isset($filters['kelas']) && $filters['kelas'] == $kelas->id) ? 'selected' : ''; ?>>
                                <?= $kelas->nama_kelas; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="status" class="form-control mr-2 mb-2">
                        <?php foreach ($status_options as $value => $label): ?>
                            <option value="<?= $value; ?>"
                                <?= (isset($filters['status']) && $filters['status'] == $value) ? 'selected' : ''; ?>>
                                <?= $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button type="submit" name="submit" value="1" class="btn btn-primary mb-2">Cari</button>
                    <a href="<?= site_url('admin/reset_search_ujian'); ?>" class="btn btn-secondary ml-2 mb-2">Reset</a>
                </form>
            </div>
        </div>

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
                                    <th>Nama Ujian</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ujian)): ?>
                                    <?php foreach ($ujian as $u): ?>
                                        <tr class="text-center">
                                            <td><?= $u->id_ujian ?></td>
                                            <td><?= $u->nama_guru ?></td>
                                            <td><?= $u->nama_mapel ?></td>
                                            <td><?= $u->nama_ujian ?></td>
                                            <td><?= $u->nama_kelas ?></td>
                                            <td>
                                                <span class="badge badge-<?= $u->status == 'aktif' ? 'success' : 'danger' ?>">
                                                    <?= ucfirst($u->status) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= site_url('admin/data_peserta/' . $u->id_ujian); ?>" class="btn btn-success btn-sm mb-1">Peserta</a>
                                                <a href="<?= site_url('admin/detail_ujian/' . $u->id_ujian); ?>" class="btn btn-info btn-sm mb-1">Detail</a>
                                                <button onclick="confirmDeleteQuiz('<?= $u->id_ujian; ?>')" class="btn btn-danger btn-sm mb-1" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- PAGINATION -->
                        <div class="mt-3">
                            <?= $pagination ?? '' ?>
                        </div>
                    </div>
                    <p class="small font-weight-bold mt-3">Tidak Ada Data Ujian yang tersedia, Silahkan Tambah Ujian</p>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->

<!-- Hapus DataTables script karena bentrok dengan pagination -->
<script>
    function confirmDeleteQuiz(id) {
        $('#deleteQuizLink').attr('href', '<?= site_url("admin/delete_ujian/"); ?>' + id);
        $('#deleteQuizModal').modal('show');
    }
</script>

<!-- Modal Konfirmasi Hapus Quiz -->
<div class="modal fade" id="deleteQuizModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuizModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteQuizModalLabel">Konfirmasi Hapus Ujian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus ujian ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a id="deleteQuizLink" href="#" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>