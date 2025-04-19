    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Pengumpulan Tugas</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>File Tugas</th>
                                <th>Dikirim Pada</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submissions as $sub): ?>
                            <tr>
                                <td><?= htmlspecialchars($sub->nama_siswa) ?></td>
                                <td>
                                    <a href="<?= base_url($sub->file_path) ?>" download>
                                        <?= htmlspecialchars($sub->original_filename) ?>
                                    </a>
                                </td>
                                <td><?= date('d M Y H:i', strtotime($sub->dikirim_pada)) ?></td>
                                <td>
                                    <?= $sub->nilai ? $sub->nilai : 'Belum dinilai' ?>
                                </td>
                                <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nilaiModal<?= $sub->id ?>">
  <i class="fas fa-edit"></i> Nilai
</button>

<a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= $sub->id; ?>')">
    <i class="fas fa-trash"></i>
</a>
                                </td>
                            </tr>
                            
                            <!-- Modal untuk memberi nilai -->
                            <div class="modal fade" id="nilaiModal<?= $sub->id ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Beri Nilai</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <?= form_open('guru/beri_nilai/'.$sub->id) ?>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nilai (0-100)</label>
                                                <input type="number" name="nilai" class="form-control" 
                                                    value="<?= $sub->nilai ?>" min="0" max="100" step="0.01">
                                            </div>
                                            <div class="form-group">
                                                <label>Catatan</label>
                                                <textarea name="catatan" class="form-control"><?= 
                                                    htmlspecialchars($sub->catatan) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                        <?= form_close() ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk memberi nilai -->
<div class="modal fade" id="nilaiModal<?= $sub->id ?>" tabindex="-1" role="dialog" aria-labelledby="nilaiModalLabel<?= $sub->id ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?= form_open('guru/beri_nilai/'.$sub->id) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="nilaiModalLabel<?= $sub->id ?>">Beri Nilai - <?= $sub->nama_siswa ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nilai (0-100)</label>
          <input type="number" name="nilai" class="form-control" value="<?= $sub->nilai ?>" min="0" max="100" step="0.01">
        </div>
        <div class="form-group">
          <label>Catatan</label>
          <textarea name="catatan" class="form-control"><?= htmlspecialchars($sub->catatan) ?></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus tugas ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    
    // Fungsi untuk memanggil modal konfirmasi
function confirmDelete(id) {
    $('#deleteLink').attr('href', '<?= site_url("guru/hapus_tugas/"); ?>' + id);
    $('#deleteModal').modal('show');
}

</script>