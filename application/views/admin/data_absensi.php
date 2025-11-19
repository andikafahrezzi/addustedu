<!-- Main Content -->
<div class="main-content">
    <section class="section">

        <!-- HEADER CARD -->
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">
                    Absensi Pertemuan: <?= $pertemuan->nama_mapel ?> - <?= $pertemuan->nama_kelas ?>
                </h2>
                <hr>
                <p class="card-text">
                    Halaman ini digunakan untuk melakukan pengelolaan absensi siswa pada pertemuan e-learning.
                    Admin dapat melihat data absensi, menghitung ulang, dan melakukan perubahan status secara manual.
                </p>

                <a href="<?= base_url('admin/hitung_ulang_absensi/'.$pertemuan->id) ?>"
                   class="btn btn-primary">
                   Hitung Ulang Absensi ⭢
                </a>
                <a href="<?= site_url('admin/export_absensi_per_pertemuan/'.$pertemuan->id); ?>" 
                    class="btn btn-sm btn-success">
                    Export Absensi ⭢
                </a>
            </div>
        </div>

        <!-- FLASH MESSAGE -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <!-- TABLE CARD -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="bg-white p-4"
                     style="border-radius:3px; box-shadow: rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">

                    <form method="POST" action="<?= base_url('admin/simpan_absensi_perubahan') ?>">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                        value="<?= $this->security->get_csrf_hash(); ?>" />
                        <input type="hidden" name="id_pertemuan" value="<?= $pertemuan->id ?>">

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Status Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if (!empty($absensi)): ?>
                                        <?php foreach ($absensi as $row): ?>
                                            <tr class="text-center">

                                                <td><?= $row->siswa_id ?></td>
                                                <td><?= $row->nama ?></td>

                                                <td>
                                                    <input type="hidden" name="absen_id[]" value="<?= $row->id ?>">

                                                    <select name="status[]" class="dropdown-absensi">
                                                        <option value="hadir"
                                                            <?= $row->status == 'hadir' ? 'selected' : '' ?>>
                                                            Hadir
                                                        </option>

                                                        <option value="tidak_hadir"
                                                            <?= $row->status == 'tidak_hadir' ? 'selected' : '' ?>>
                                                            Tidak Hadir
                                                        </option>
                                                    </select>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>

                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data absensi</td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>

                    </form>

                </div>
            </div>
        </div>

    </section>
</div>
<!-- End Main Content -->
<style>
    .dropdown-absensi {
        border: 1px solid #ced4da !important;
        padding: 6px 10px !important;
        border-radius: 5px;
        background: #ffffff !important;
        color: #333 !important;
        font-size: 14px;
        appearance: auto !important; /* tampilkan arrow default browser */
        box-shadow: 0px 1px 3px rgba(0,0,0,0.08);
        cursor: pointer;
    }
    .dropdown-absensi:focus {
        border-color: #5cb85c !important;
        box-shadow: 0px 0px 5px rgba(92,184,92,0.5) !important;
    }
</style>
