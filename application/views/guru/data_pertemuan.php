<!-- application/views/guru/data_pertemuan.php -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Management Pertemuan</h2>
                <hr>
                <p class="card-text">Kelola jadwal pertemuan pembelajaran untuk materi yang Anda buat.</p>
                <a href="<?= site_url('pertemuan/tambah') ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Pertemuan Baru
                </a>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>
            <!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" action="<?= site_url('pertemuan') ?>" class="row">
            <div class="col-md-3 mb-2">
                <select name="mapel" class="form-control">
                    <option value="">-- Semua Mapel --</option>
                    <?php foreach ($mapel_list as $mapel): ?>
                        <option value="<?= $mapel->id ?>" <?= (isset($filters['mapel']) && $filters['mapel'] == $mapel->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($mapel->nama_mapel) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select name="kelas" class="form-control">
                    <option value="">-- Semua Kelas --</option>
                    <?php foreach ($kelas_list as $kelas): ?>
                        <option value="<?= $kelas->id ?>" <?= (isset($filters['kelas']) && $filters['kelas'] == $kelas->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kelas->nama_kelas) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="keyword" class="form-control" placeholder="Cari mapel, kelas, atau deskripsi..." value="<?= isset($filters['keyword']) ? htmlspecialchars($filters['keyword']) : '' ?>">
            </div>
            <div class="col-md-2 mb-2">
                <button type="submit" name="submit" value="1" class="btn btn-primary btn-block">Cari</button>
                <a href="<?= site_url('pertemuan') ?>" class="btn btn-secondary btn-block mt-1">Reset</a>
            </div>
        </form>
    </div>
</div>
        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Pertemuan Ke</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi Materi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pertemuan)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($pertemuan as $p): ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($p->nama_mapel) ?></td>
                                            <td><?= htmlspecialchars($p->nama_kelas) ?></td>
                                            <td>Pertemuan <?= $p->pertemuan_ke ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal)) ?></td>
                                            <td>
                                                <?= strlen($p->deskripsi) > 50 ? substr(htmlspecialchars($p->deskripsi), 0, 50).'...' : htmlspecialchars($p->deskripsi) ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('absensi/lihat/'.$p->id) ?>" class="btn btn-sm btn-info" title="Lihat Absensi">
                                                        <i class="fas fa-users"></i>
                                                    </a>
                                                    <a href="<?= site_url('guru/belajar/'.$p->id) ?>" class="btn btn-sm btn-success" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= site_url('pertemuan/edit/'.$p->id) ?>" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button onclick="confirmDelete('<?= $p->id ?>')" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-calendar-times fa-3x mb-2"></i>
                                                <br>
                                                Belum ada pertemuan yang dibuat.
                                                <br>
                                                <a href="<?= site_url('pertemuan/tambah') ?>" class="btn btn-primary mt-2">
                                                    Buat Pertemuan Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                Apakah Anda yakin ingin menghapus pertemuan ini? 
                <br><small class="text-danger">Data forum diskusi dan tugas yang terkait juga akan dihapus.</small>
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
    $('#deleteLink').attr('href', '<?= site_url("pertemuan/delete/") ?>' + id);
    $('#deleteModal').modal('show');
}
</script>