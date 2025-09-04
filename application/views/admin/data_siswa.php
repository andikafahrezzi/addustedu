
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title" style="color: black;">Management Data Siswa Ctkarya</h2>
                            <hr>
                            <p class="card-text"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction. </p>
                            <a href="<?= base_url('admin/add_siswa') ?>" class="btn btn-success">Tambah
                                Data Siswa ⭢ </a>
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
                                <div class="mb-3">
                                    <form action="<?= site_url('admin/data_siswa'); ?>" method="get" class="form-inline">
                                        <!-- Hapus CSRF token karena menggunakan GET -->
                                        
                                        <input type="text" name="keyword" class="form-control mr-2"
                                            placeholder="Cari nama / NIS..."
                                            value="<?= isset($filters['keyword']) ? html_escape($filters['keyword']) : ''; ?>">

                                        <select name="kelas" class="form-control mr-2">
                                            <option value="">-- Semua Kelas --</option>
                                            <?php foreach ($kelas_list as $k): ?>
                                                <option value="<?= $k->id; ?>"
                                                    <?= (isset($filters['kelas']) && $filters['kelas'] == $k->id) ? 'selected' : ''; ?>>
                                                    <?= $k->nama_kelas; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <button type="submit" name="submit" value="search" class="btn btn-primary">Cari</button>
                                        <a href="<?= site_url('admin/reset_search'); ?>" class="btn btn-secondary ml-2">Reset</a>
                                    </form>
                                </div>

                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr class="text-center">
                                            <th>Nis</th>
                                            <th>Nama Siswa</th>
                                            <th>Email</th>
                                            <th>Kelas</th>
                                            <th>Detail</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($siswa)): ?>
                                            <?php foreach ($siswa as $u): ?>
                                                <tr class="text-center">
                                                    <td><?= $u->nis ?></td>
                                                    <td><?= $u->nama ?></td>
                                                    <td><?= $u->email ?></td>
                                                    <td><?= $u->nama_kelas ?></td>
                                                    <td><a href="<?= site_url('admin/detail_siswa/' . $u->nis); ?>" class="btn btn-success">Detail</a></td>
                                                    <td>
                                                        <a href="<?= site_url('admin/update_siswa/' . $u->nis); ?>" class="btn btn-info">Update</a>
                                                        <a href="<?= site_url('admin/delete_siswa/' . $u->nis); ?>" class="btn btn-danger remove">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="8" class="text-center">Data tidak ditemukan</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    <?= $pagination; ?>
                                </div>

                                    <p class="small font-weight-bold">* Angka 1 menunjukan akun telah aktif sedangkan
                                        Angka
                                        0 menunjukan akun
                                        belum
                                        aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    <!-- End Main Content -->

    <!-- Start Sweetalert -->

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>