<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Management Data Materi Ctkarya</h2>
                <hr>
                <p class="card-text">After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction.</p>
                <a href="<?= base_url('admin/add_materi') ?>" class="btn btn-success">Tambah Data Materi ⭢</a>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <!-- SEARCH FORM -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?= site_url('admin/data_materi'); ?>" method="get" class="form-inline">
                    <input type="text" name="keyword" class="form-control mr-2 mb-2"
                           placeholder="Cari deskripsi, guru, mapel, atau kelas..."
                           value="<?= isset($filters['keyword']) ? html_escape($filters['keyword']) : ''; ?>">
                    
                    <select name="mapel" class="form-control mr-2 mb-2">
                        <option value="">-- Semua Mapel --</option>
                        <?php foreach ($mapel_list as $mapel): ?>
                            <option value="<?= $mapel->id; ?>"
                                <?= (isset($filters['mapel']) && $filters['mapel'] == $mapel->id) ? 'selected' : ''; ?>>
                                <?= $mapel->nama_mapel; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="kelas" class="form-control mr-2 mb-2">
                        <option value="">-- Semua Kelas --</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                            <option value="<?= $kelas->id; ?>"
                                <?= (isset($filters['kelas']) && $filters['kelas'] == $kelas->id) ? 'selected' : ''; ?>>
                                <?= $kelas->nama_kelas; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button type="submit" name="submit" value="1" class="btn btn-primary mb-2">Cari</button>
                    <a href="<?= site_url('admin/reset_search_materi'); ?>" class="btn btn-secondary ml-2 mb-2">Reset</a>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Guru</th>
                                    <th>Mapel</th>
                                    <th>Deskripsi</th>
                                    <th>Kelas</th>
                                    <th>File</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($materi)): ?>
                                    <?php foreach ($materi as $u): ?>
                                        <tr class="text-center">
                                            <td><?= $u->id ?></td>
                                            <td><?= $u->nama_guru ?></td>
                                            <td><?= $u->nama_mapel ?></td>
                                            <td>
    <?= strlen($u->deskripsi) > 10 ? substr($u->deskripsi, 0, 10) . '...' : $u->deskripsi ?>
    <?php if (strlen($u->deskripsi) > 10): ?>
        <span class="text-muted" title="<?= html_escape($u->deskripsi) ?>"></span>
    <?php endif; ?>
</td>
                                            <td><?= $u->nama_kelas ?></td>
                                            <td>
                                                <?php if (!empty($u->modul)): ?>
                                                    <a href="<?= base_url('uploads/materi/' . $u->modul) ?>" 
                                                       class="btn btn-sm btn-success" download>
                                                        Download
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= site_url('admin/update_materi/' . $u->id); ?>" class="btn btn-info btn-sm mb-1">Update</a>
                                                <a href="<?= site_url('admin/delete_materi/' . $u->id); ?>" class="btn btn-danger btn-sm remove mb-1">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- PAGINATION -->
                        <div class="mt-3">
                            <?= $pagination ?? '' ?>
                        </div>
                    </div>
                    <p class="small font-weight-bold mt-3">Sebelum mengupload file, harus terlebih dahulu melakukan config max_upload di php.ini</p>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->