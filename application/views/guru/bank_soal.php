<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bank Soal - <?= $this->session->userdata('nama_mapel') ?></h1>
        <a href="<?= site_url('guru/add_bank_soal') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Soal
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Soal</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Tipe Soal</th>
                        <th>Mapel</th>
                        <th>Dibuat oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bank_soal as $i => $soal): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= character_limiter($soal->pertanyaan, 50) ?></td>
                        <td><?= $soal->tipe_soal == 'pilihan' ? 'Pilihan Ganda' : 'Essay' ?></td>
                        <td><?= $soal->nama_mapel ?></td>
                        <td><?= $soal->user_type ?></td>
                        <td>
                        <a href="<?= site_url('guru/edit_bank_soal/'.$soal->id_soal) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button onclick="hapusSoal(<?= $soal->id_soal ?>)" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
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
function hapusSoal(id) {
        $('#deleteLink').attr('href', '<?= site_url("guru/hapus_bank_soal/"); ?>' + id);
        $('#deleteModal').modal('show');
    }
</script>