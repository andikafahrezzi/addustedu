<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Daftar Tugas Siswa</h4>
        </div>
        <div class="card-body">
            <?php if (count($submissions) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Siswa</th>
                            <th>File Tugas</th>
                            <th>Waktu Kirim</th>
                            <th>Status Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submissions as $sub): ?>
                        <tr>
                            <td><?= htmlspecialchars($sub->nama_siswa) ?></td>
                            <td>
                                <a href="<?= base_url($sub->file_path) ?>" download>
                                    <i class="fas fa-file-download"></i>
                                    <?= htmlspecialchars($sub->original_filename) ?>
                                </a>
                            </td>
                            <td><?= date('d M Y H:i', strtotime($sub->dikirim_pada)) ?></td>
                            <td>
                                <?php if ($sub->nilai !== null): ?>
                                    <span class="badge badge-success">Sudah Dinilai (<?= $sub->nilai ?>)</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Belum Dinilai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nilaiModal<?= $sub->id ?>">
                                        <i class="fas fa-edit"> Nilai </i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= $sub->id ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Nilai -->
                        <div class="modal fade" id="nilaiModal<?= $sub->id ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?= $sub->id ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <?= form_open('guru/beri_nilai/'.$sub->id) ?>
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalLabel<?= $sub->id ?>">Nilai Tugas - <?= $sub->nama_siswa ?></h5>
                                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nilai (0-100)</label>
                                            <input type="number" name="nilai" class="form-control" value="<?= $sub->nilai ?>" min="0" max="100" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea name="catatan" class="form-control" rows="3"><?= htmlspecialchars($sub->catatan) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    </div>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="alert alert-info">Belum ada tugas yang dikumpulkan.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus tugas ini secara permanen?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a id="deleteLink" href="#" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>


<script>
    function confirmDelete(id) {
        $('#deleteLink').attr('href', '<?= site_url("guru/hapus_tugas/"); ?>' + id);
        $('#deleteModal').modal('show');
    }
</script>
