<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Daftar RPS Guru</h2>
                <hr>
                <p class="card-text">Berikut daftar RPS yang telah diupload oleh seluruh guru. Admin dapat melihat atau menghapus RPS.</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0,0,0,0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table id="rpsTable" class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Guru</th>
                                    <th scope="col">Mata Pelajaran</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">File RPS</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php if(!empty($rps_grouped)) : ?>
    <?php $no = 1; ?>
    <?php foreach($rps_grouped as $group => $items) : ?>
        <tr class="table-info">
            <td colspan="7" style="font-weight:bold"><?= $group ?></td>
        </tr>
        <?php foreach($items as $r) : ?>
        <tr class="text-center">
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($r->nama_guru) ?></td>
            <td><?= htmlspecialchars($r->nama_mapel) ?></td>
            <td><?= htmlspecialchars($r->nama_kelas) ?></td>
            <td><?= htmlspecialchars($r->semester) ?></td>
            <td><?= htmlspecialchars($r->file_rps) ?></td>
            <td>
                <a href="<?= base_url('./assets/rps_uploads/'.$r->file_rps) ?>" class="btn btn-sm btn-primary" target="_blank" title="Lihat">
                    <i class="fas fa-eye"></i>
                </a>
                <button onclick="confirmDelete('<?= $r->id_rps ?>')" class="btn btn-sm btn-danger" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="7" class="text-center">Belum ada RPS yang diupload</td>
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
                Apakah Anda yakin ingin menghapus RPS ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#rpsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });

    function confirmDelete(id) {
        $('#deleteLink').attr('href', '<?= site_url("admin/delete_rps_by_admin/"); ?>' + id);
        $('#deleteModal').modal('show');
    }
</script>
