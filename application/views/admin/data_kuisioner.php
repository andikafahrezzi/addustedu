<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Management Data Kuisioner</h2>
                <hr>
                <p class="card-text">
                    Halaman ini digunakan untuk mengelola data kuisioner. 
                    Admin dapat menambahkan kuisioner baru, mengedit, menghapus, serta melihat hasil pengisian dari guru dan siswa.
                </p>
                <a href="<?= base_url('kuisioner/create') ?>" class="btn btn-success">Tambah Kuisioner ⭢</a>
            </div>
        </div>

        <!-- FLASH MESSAGE -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Judul</th>
                                    <th>Target</th>
                                    <th>Status</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($kuisioner)): ?>
                                    <?php foreach ($kuisioner as $k): ?>
                                        <tr class="text-center">
                                            <td><?= $k->id ?></td>
                                            <td><?= $k->judul ?></td>
                                            <td><?= ucfirst($k->target) ?></td>
                                            <td>
                                                <?= $k->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Nonaktif</span>' ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('kuisioner/edit/'.$k->id) ?>" class="btn btn-info btn-sm mb-1">Edit</a>
                                                <a href="<?= base_url('kuisioner/delete/'.$k->id) ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin hapus?')">Delete</a>
                                                <a href="<?= base_url('kuisioner/pertanyaan/'.$k->id) ?>" class="btn btn-primary btn-sm mb-1">Pertanyaan</a>
                                                <a href="<?= base_url('kuisioner/hasil/'.$k->id) ?>" class="btn btn-warning btn-sm mb-1">Hasil</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Data kuisioner belum ada</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <!-- PAGINATION kalau ada -->
                        <div class="mt-3">
                            <?= $pagination ?? '' ?>
                        </div>
                    </div>
                    <p class="small font-weight-bold mt-3">Gunakan kuisioner ini untuk mengukur kepuasan pengguna sistem e-learning.</p>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->
