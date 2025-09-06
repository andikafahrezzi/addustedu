<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📚 Daftar Materi</h3>
        <a href="<?= site_url('guru/add_materi') ?>" class="btn btn-success">+ Tambah Materi</a>
    </div>

<form method="get" action="<?= site_url('guru/data_materi') ?>" class="form-row mb-3">
    <div class="col-md-3 mb-2">
        <select name="mapel" class="form-control">
            <option value="">-- Semua Mata Pelajaran --</option>
            <?php foreach($mapel_list as $mp): ?>
                <option value="<?= $mp['id'] ?>" <?= (isset($filter_mapel) && $filter_mapel == $mp['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($mp['nama_mapel']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3 mb-2">
        <select name="kelas" class="form-control">
            <option value="">-- Semua Kelas --</option>
            <?php foreach($kelas_list as $k): ?>
                <option value="<?= $k['id'] ?>" <?= (isset($filter_kelas) && $filter_kelas == $k['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama_kelas']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4 mb-2">
        <input type="text" name="keyword" class="form-control" placeholder="Cari judul/deskripsi/mapel/kelas..." value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>">
    </div>
    <div class="col-md-2 mb-2">
        <button type="submit" class="btn btn-primary btn-block">🔍 Cari</button>
        <?php if (isset($filter_mapel) || isset($filter_kelas) || isset($keyword)): ?>
            <a href="<?= site_url('guru/data_materi') ?>" class="btn btn-secondary btn-block mt-1">Reset</a>
        <?php endif; ?>
    </div>
</form>

    <?php if (!empty($this->session->flashdata('success'))): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if (!empty($this->session->flashdata('error'))): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Mapel</th>
                            <th>Deskripsi</th>
                            <th>Kelas</th>
                            <th>Guru</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php if (!empty($materi)): foreach($materi as $m): ?>
                                <tr>
                                    <td><?= htmlspecialchars($m['nama_mapel']) ?></td>
                                    <td>
                                        <?= htmlspecialchars(mb_strimwidth($m['deskripsi'],0,120,'...')) ?>
                                        <?php if (!empty($m['video'])): ?>
                                            <br><small class="text-muted">Video: <?= htmlspecialchars($m['video']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($m['nama_kelas']) ?></td>
                                    <td><?= htmlspecialchars($m['nama_guru']) ?></td>
                                    <td>
                                        <?php if ($m['id_guru'] == $current_guru_nip): ?>
                                            <!-- Milik guru yang login - tampilkan edit/delete -->
                                            <a href="<?= site_url('guru/update_materi/'.$m['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <button onclick="confirmDelete('<?= $m['id']; ?>')" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php else: ?>
                                            <!-- Bukan milik guru yang login - hanya view -->
                                            <span class="text-muted" title="Hanya bisa dilihat">Tidak Ada Aksi</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-2"></i>
                                            <br>
                                            Tidak ada materi yang ditemukan.
                                            <?php if (isset($filter_mapel) || isset($filter_kelas) || isset($keyword)): ?>
                                                <br>
                                                <small>Coba dengan filter yang berbeda atau <a href="<?= site_url('guru/data_materi') ?>">reset filter</a></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 text-center">
        <?= $pagination ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
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
                Apakah Anda yakin ingin menghapus materi ini?
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
        $('#deleteLink').attr('href', '<?= site_url("guru/delete_materi/"); ?>' + id);
        $('#deleteModal').modal('show');
    }
</script>