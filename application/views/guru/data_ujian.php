<div class="container mt-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Ujian</h6>
        <a href="<?= base_url('guru/tambah_ujian') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Buat Ujian Baru
        </a>
    </div>

    <?php foreach ($ujian_terstruktur as $tingkat => $mapelList): ?>
        <h4 class="mt-4 text-success">Tingkat: <?= $tingkat ?></h4>
        
        <?php foreach ($mapelList as $mapel => $kelasList): ?>
            <h5 class="text-info">Mata Pelajaran: <?= $mapel ?></h5>

            <?php foreach ($kelasList as $kelas => $ujianList): ?>
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <strong>Kelas: <?= $kelas ?></strong>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ujian</th>
                                    <th>Pertemuan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ujianList as $i => $u): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $u['nama_ujian'] ?></td>
                                        <td><?= $u['pertemuan_ke'] ?></td>
                                        <td><?= $u['tanggal_mulai'] ?></td>
                                        <td><?= $u['tanggal_selesai'] ?></td>
                                        <td><?= ucfirst($u['status']) ?></td>
                                        <td class="text-center">
                                            <a href="<?= site_url('guru/data_pesertaujian/' . $u['id_ujian']) ?>" class="btn btn-sm btn-info mb-1">Peserta</a>
                                            <a href="<?= site_url('guru/daftar_nilai_essay/' . $u['id_ujian']) ?>" class="btn btn-sm btn-info mb-1">Essay</a>
                                            <a href="<?= site_url('guru/tampilkan_soal/' . $u['id_ujian']) ?>" class="btn btn-sm btn-info mb-1">Soal</a>
                                            <a href="<?= site_url('guru/edit_ujian/' . $u['id_ujian']) ?>" class="btn btn-sm btn-warning mb-1">Edit</a>
                                            <button onclick="confirmDeleteUjian('<?= $u['id_ujian']; ?>')" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>


<!-- Modal Konfirmasi Hapus Quiz -->
<div class="modal fade" id="deleteUjianModal" tabindex="-1" role="dialog" aria-labelledby="deleteUjianModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteUjianModalLabel">Konfirmasi Hapus Ujian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus quiz ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a id="deleteUjianLink" href="#" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>

<script>
    function confirmDeleteQuiz(id) {
        $('#deleteUjianLink').attr('href', '<?= site_url('guru/hapus_ujian/' . $u['id_ujian']) ?>');
        $('#deleteUjianModal').modal('show');
    }
</script>