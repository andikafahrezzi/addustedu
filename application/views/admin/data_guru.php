<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Management Data Guru</h2>
                <hr>
                <p class="card-text">Kelola data guru dan mata pelajaran yang diajar.</p>
                <a href="<?= base_url('admin/add_guru') ?>" class="btn btn-success">Tambah Data Guru ⭢</a>
            </div>
        </div>

        <?php if ($this->session->flashdata('success-delete')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success-delete') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error-delete')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error-delete') ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px;">
                    <div class="table-responsive">
                        <!-- SEARCH FORM -->
                        <div class="mb-3">
                            <form action="<?= site_url('admin/data_guru'); ?>" method="get" class="form-inline">
                                <input type="text" name="keyword" class="form-control mr-2"
                                       placeholder="Cari NIP, Nama, atau Email..."
                                       value="<?= isset($filters['keyword']) ? html_escape($filters['keyword']) : ''; ?>">
                                
                                <button type="submit" name="submit" value="1" class="btn btn-primary">Cari</button>
                                <a href="<?= site_url('admin/reset_search_guru'); ?>" class="btn btn-secondary ml-2">Reset</a>
                            </form>
                        </div>

                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>NUPTK</th>
                                    <th>Nama Guru</th>
                                    <th>Email</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($guru)): ?>
                                    <?php foreach ($guru as $g): ?>
                                        <tr class="text-center">
                                            <td><?= $g->nuptk ?></td>
                                            <td><?= $g->nama_guru ?></td>
                                            <td><?= $g->email ?></td>
                                            <td><?= !empty($g->mapel_diajar) ? $g->mapel_diajar : 'Belum ada mapel' ?></td>
                                            <td>
                                                <a href="<?= site_url('admin/update_guru/' . $g->nip); ?>" class="btn btn-info">Update</a>
                                                <!-- Trigger modal delete -->
                                                <button onclick="confirmDelete('<?= $g->nip; ?>')" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- PAGINATION -->
                        <div class="mt-3">
                            <?= $pagination ?? '' ?>
                        </div>
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
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data guru ini?
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
        $('#deleteLink').attr('href', '<?= site_url("admin/delete_guru/"); ?>' + id);
        $('#deleteModal').modal('show');
    }
</script>
<!-- End Main Content -->
