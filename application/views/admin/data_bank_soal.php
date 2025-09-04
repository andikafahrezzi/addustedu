
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="card" style="width:100%;">
                        <div class="card-body">
                            <h2 class="card-title" style="color: black;">Management Data Materi addustedu</h2>
                            <hr>
                            <p class="card-text"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction.</p>
                            <a href="<?= base_url('admin/add_bank_soal') ?>" class="btn btn-success">Tambah
                                Bank Soal⭢</a>
                        </div>
                    </div>
                                        <?php if($this->session->flashdata('error-delete')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error-delete'); ?>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('success-delete')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success-delete'); ?>
    </div>
<?php endif; ?>
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?= site_url('admin/bank_soal'); ?>" method="get" class="form-inline">
                    <input type="text" name="keyword" class="form-control mr-2 mb-2"
                           placeholder="Cari pertanyaan, mapel, atau kata kunci..."
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
                    
                    <select name="tipe_soal" class="form-control mr-2 mb-2">
                        <?php foreach ($tipe_soal_options as $value => $label): ?>
                            <option value="<?= $value; ?>"
                                <?= (isset($filters['tipe_soal']) && $filters['tipe_soal'] == $value) ? 'selected' : ''; ?>>
                                <?= $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select name="tingkat_kesulitan" class="form-control mr-2 mb-2">
                        <?php foreach ($tingkat_kesulitan_options as $value => $label): ?>
                            <option value="<?= $value; ?>"
                                <?= (isset($filters['tingkat_kesulitan']) && $filters['tingkat_kesulitan'] == $value) ? 'selected' : ''; ?>>
                                <?= $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button type="submit" name="submit" value="1" class="btn btn-primary mb-2">Cari</button>
                    <a href="<?= site_url('admin/reset_search_bank_soal'); ?>" class="btn btn-secondary ml-2 mb-2">Reset</a>
                </form>
            </div>
        </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                                <div class="table-responsive">
                                    <table id="example" class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                            <th width="5%">No</th>
                                            <th>Pertanyaan</th>
                                            <th width="15%">Mata Pelajaran</th>
                                            <th width="10%">Tipe Soal</th>
                                            <th width="10%">Pembuat</th>
                                            <th width="15%">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <tbody>
                        <?php $no = 1; foreach ($soal as $s): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= character_limiter(strip_tags($s->pertanyaan), 100) ?></td>
                            <td><?= $s->nama_mapel ?></td>
                            <td><?= $s->tipe_soal ?></td>
                            <td><?= $s->user_type == 'admin' ? 'Admin' : 'Guru #'.$s->created_by ?></td>
                            <td>
                                <a href="<?= site_url('admin/edit_bank_soal/'.$s->id_soal) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button onclick="hapusSoal(<?= $s->id_soal ?>)" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="small font-weight-bold">Sebelum mengupload file, harus terlebih dahulu
                                    melakukan config max_upload di php.ini</p>
                                    <div class="mt-3">
                                        <?= $pagination ?? '' ?>
                                    </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->


    <!-- Start Sweetalert -->

    <?php if ($this->session->flashdata('success-edit')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Materi Telah Dirubah!',
                text: 'Selamat data berubah!',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('user-delete')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Materi Telah Dihapus!',
                text: 'Selamat data telah Dihapus!',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success-reg')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Materi Telah Ditambah!',
                text: 'Selamat data telah Ditambah!',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php endif; ?>

    <script>
function hapusSoal(id) {
    if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
        window.location.href = "<?= site_url('admin/hapus_soal_fix/') ?>" + id;
    }
}
</script>
    <!-- End Sweetalert -->
