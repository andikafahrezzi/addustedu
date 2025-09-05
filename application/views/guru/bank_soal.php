<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-success">Bank Soal</h1>
        <a href="<?= site_url('guru/add_bank_soal') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Soal
        </a>
    </div>
                <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
<?php if (!empty($mapel_diajarkan)): ?>
<div class="mb-3 text-success">
    <label for="filterMapel"><strong>Filter Mata Pelajaran:</strong></label>
    <select class="form-control" id="filterMapel" onchange="filterSoal()">
        <option value="semua" <?= ($filter_mapel == 'semua' || !$filter_mapel) ? 'selected' : '' ?>>Semua Mapel</option>
        <?php foreach ($mapel_diajarkan as $mapel): ?>
            <option value="<?= $mapel->nama_mapel ?>" <?= ($filter_mapel == $mapel->nama_mapel) ? 'selected' : '' ?>>
                <?= $mapel->nama_mapel ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<?php endif; ?>




    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Daftar Soal</h6>
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
<tr data-mapel="<?= $soal->nama_mapel ?>">
    <td><?= $i+1 ?></td>
    <td><?= character_limiter($soal->pertanyaan, 50) ?></td>
    <td><?= $soal->tipe_soal == 'pilihan' ? 'Pilihan Ganda' : 'Essay' ?></td>
    <td><?= $soal->nama_mapel ?></td>
    <td><?= $soal->user_type == 'guru' ? 'Guru#' . $soal->pembuat : 'Admin' ?></td>
    <td>
        <?php if ($soal->created_by === $this->session->userdata('nip')): ?>
            <a href="<?= site_url('guru/edit_bank_soal/'.$soal->id_soal) ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <button onclick="hapusSoal(<?= $soal->id_soal ?>)" class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i> Hapus
            </button>
        <?php else: ?>
            <span class="text-muted">-</span>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
            </table>
            <div class="row mt-3">
    <div class="col-md-12">
        <?= $pagination ?? '' ?>
    </div>
</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
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

function filterSoal() {
    var selected = document.getElementById('filterMapel').value;
    var rows = document.querySelectorAll('tbody tr');

    rows.forEach(function(row) {
        var mapel = row.getAttribute('data-mapel');
        if (selected === 'semua' || mapel === selected) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
<script>
function filterSoal() {
    var mapel = document.getElementById("filterMapel").value;
    var url = "<?= site_url('guru/bank_soal'); ?>?mapel=" + mapel;
    window.location.href = url;
}
</script>