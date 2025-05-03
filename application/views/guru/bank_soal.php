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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bank_soal as $i => $soal): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= character_limiter($soal->pertanyaan, 50) ?></td>
                        <td><?= $soal->tipe_soal == 'pilihan' ? 'Pilihan Ganda' : 'Essay' ?></td>
                        <td><?= $soal->mapel_diajarkan ?></td>
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

<script>
function hapusSoal(id) {
    if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
        window.location.href = "<?= site_url('guru/bank_soal/hapus/') ?>" + id;
    }
}
</script>