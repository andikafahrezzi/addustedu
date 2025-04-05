<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Management Materi Saya</h2>
                <hr>
                <p class="card-text">Berikut daftar materi pembelajaran yang telah Anda buat. Anda dapat mengelola materi-materi ini sesuai kebutuhan.</p>
                <a href="<?= base_url('guru/add_materi') ?>" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Materi Baru
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table id="materiTable" class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Mata Pelajaran</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Dibuat</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($materi)) : ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($materi as $m) : ?>
                                        <tr class="text-center">
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($m->nama_mapel); ?></td>
                                            <td>
                                                <?= strlen($m->deskripsi) > 50 ? substr(htmlspecialchars($m->deskripsi), 0, 50).'...' : htmlspecialchars($m->deskripsi); ?>
                                            </td>
                                            <td>Kelas <?= htmlspecialchars($m->kelas); ?></td>
                                            <td><?= htmlspecialchars($m->modul); ?></td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('guru/update_materi/'.$m->id); ?>" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button onclick="confirmDelete('<?= $m->id; ?>')" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada materi yang dibuat</td>
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
                Apakah Anda yakin ingin menghapus materi ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert Notifications -->
<?php if ($this->session->flashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $this->session->flashdata('success'); ?>',
            showConfirmButton: false,
            timer: 2500
        });
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= $this->session->flashdata('error'); ?>',
            showConfirmButton: false,
            timer: 2500
        });
    </script>
<?php endif; ?>

<!-- JavaScript -->
<script>
    // DataTable Initialization
    $(document).ready(function() {
        $('#materiTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });

    // Delete Confirmation
    function confirmDelete(id) {
        $('#deleteLink').attr('href', '<?= site_url("guru/delete_materi/"); ?>' + id);
        $('#deleteModal').modal('show');
    }
</script>