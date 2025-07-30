<!-- Main Content -->
<?php
function singkat_jurusan($jurusan) {
    if (strlen($jurusan) <= 15) {
        return $jurusan; // jika pendek, tampilkan utuh
    }

    $kata = explode(' ', $jurusan);
    $singkatan = '';

    foreach ($kata as $k) {
        if (ctype_alpha($k[0])) {
            $singkatan .= strtoupper($k[0]);
        }
    }

    return $singkatan;
}
?>

<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Manajemen Data Kelas</h2>
                <hr>
                <p class="card-text">Di bawah ini adalah daftar kelas yang sudah terdaftar dalam sistem Addustedu.</p>
                <a href="<?= base_url('admin/add_kelas') ?>" class="btn btn-success">Tambah Data Kelas ⭢</a>
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
                                    <th scope="col">Kode Kelas</th>
                                    <th scope="col">Tingkat</th>
                                    <th scope="col">Jurusan</th>
                                    <th scope="col">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kelas as $k): ?>
                                    <tr class="text-center">
                                        <th scope="row"><?php echo $k->id ?></th>
                                        <td><?php echo $k->nama_kelas ?></td>
                                        <td><?php echo $k->tingkat ?></td>
                                        <td><?= singkat_jurusan($k->jurusan ?? '-') ?></td>
                                        <td class="text-center">
                                            <a href="<?= site_url('admin/update_kelas/' . $k->id) ?>" class="btn btn-info">Edit ⭢</a>
                                            <a href="<?= site_url('admin/hapus_kelas/' . $k->id) ?>" class="btn btn-danger remove">Hapus ✖</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>
</div>
<!-- End Main Content -->

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
