<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Manajemen Data Mata Pelajaran</h2>
                <hr>
                <p class="card-text">
                    Halaman ini digunakan untuk mengelola data mata pelajaran di sistem e-learning ADDUSTEDU.
                </p>
                <a href="<?= base_url('admin/add_mapel') ?>" class="btn btn-success">Tambah Mapel ⭢</a>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px;">
                    <div class="table-responsive">
                        <table id="example" class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th scope="col">ID</th>
                                    <th scope="col">Nama Mata Pelajaran</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Opsi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($mapel as $m): ?>
                                    <tr class="text-center">
                                        <td><?= $m->id ?></td>
                                        <td><?= $m->nama_mapel ?></td>
                                        <td><?= $m->deskripsi ?></td>
                                        <td class="text-center">
                                            <a href="<?= site_url('admin/edit_mapel/' . $m->id) ?>" class="btn btn-info">Edit ⭢</a>
                                            <a href="<?= site_url('admin/hapus_mapel/' . $m->id) ?>" class="btn btn-danger remove" onclick="return confirm('Yakin ingin menghapus mapel ini?')">Hapus ✖</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="small font-weight-bold">
                            * Pastikan tidak menghapus mapel yang sedang digunakan oleh guru atau materi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Start Sweetalert -->
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
