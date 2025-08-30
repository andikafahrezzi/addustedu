<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Daftar Peserta Ujian ID: <?= $id_ujian ?></h2>
                <hr>
                <p class="card-text">Berikut adalah daftar siswa yang telah mengerjakan ujian. 
                   Admin dapat menghapus jawaban siswa tertentu agar siswa dapat mengulang kembali ujian.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table id="example" class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th scope="col">NIS</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($peserta)): ?>
                                    <tr class="text-center">
                                        <td colspan="3">Belum ada peserta ujian ini</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($peserta as $p): ?>
                                    <tr class="text-center">
                                        <td><?= $p->nis ?></td>
                                        <td><?= $p->nama ?></td>
                                        <td>
                                            <button onclick="confirmDeletePeserta('<?= $id_ujian ?>','<?= $p->nis ?>')" 
                                                    class="btn btn-sm btn-danger" title="Hapus Jawaban">
                                                <i class="fas fa-trash"></i> Hapus Jawaban
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="small font-weight-bold">Hapus jawaban siswa akan mengakibatkan siswa dapat mengulang ujian ini dari awal.</p>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Main Content -->


<!-- Start Sweetalert Flashdata -->
<?php if ($this->session->flashdata('success-edit')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Data Telah Dirubah!',
            text: '<?= $this->session->flashdata("success-edit"); ?>',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('user-delete')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Data Telah Dihapus!',
            text: '<?= $this->session->flashdata("user-delete"); ?>',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('success-reg')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Data Telah Ditambah!',
            text: '<?= $this->session->flashdata("success-reg"); ?>',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $this->session->flashdata("success"); ?>',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= $this->session->flashdata("error"); ?>',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>
<!-- End Sweetalert Flashdata -->


<!-- Modal Konfirmasi Hapus Jawaban -->
<div class="modal fade" id="deletePesertaModal" tabindex="-1" role="dialog" aria-labelledby="deletePesertaModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deletePesertaModalLabel">Konfirmasi Hapus Jawaban</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus semua jawaban siswa ini untuk ujian ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a id="deletePesertaLink" href="#" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>

<script>
    function confirmDeletePeserta(id_ujian, nis) {
        $('#deletePesertaLink').attr('href', '<?= site_url("admin/hapus_jawaban_siswa/"); ?>' + id_ujian + '/' + nis);
        $('#deletePesertaModal').modal('show');
    }
</script>
