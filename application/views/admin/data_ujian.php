
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="card" style="width:100%;">
                        <div class="card-body">
                            <h2 class="card-title" style="color: black;">Management Data Ujian addustedu</h2>
                            <hr>
                            <p class="card-text"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction.</p>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                                <div class="table-responsive">
                                    <table id="example" class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                                <th scope="col">ID</th>
                                                <th scope="col">Nama Guru</th>
                                                <th scope="col">Nama Mapel</th>
                                                <th scope="col">Jenis Ujian</th>
                                                <th scope="col">Kelas</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Option</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php

                                            foreach ($user as $u) {
                                            ?>
                                                <tr class="text-center">

                                                    <th scope="row">
                                                        <?php echo $u->id_ujian ?>
                                                    </th>

                                                    <td>
                                                        <?php echo $u->nip_guru ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $u->nama_mapel ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u->nama_ujian ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u->nama_kelas ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u->status ?>
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="<?php echo site_url('admin/data_peserta/' . $u->id_ujian); ?>" class="btn btn-success">Peserta Ujian ⭢</a>
                                                        <a href="<?php echo site_url('admin/detail_ujian/' . $u->id_ujian); ?>" class="btn btn-success">Detail ⭢</a>
                                                        <button onclick="confirmDeleteQuiz('<?= $u->id_ujian; ?>')" class="btn btn-sm btn-danger" title="Hapus">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="small font-weight-bold">Tidak Ada Data Quiz yg tersedia, Silahkan Tambah Quiz</p>
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

    <!-- End Sweetalert -->
<!-- Modal Konfirmasi Hapus Quiz -->
<div class="modal fade" id="deleteQuizModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuizModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteQuizModalLabel">Konfirmasi Hapus Ujian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus ujian ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a id="deleteQuizLink" href="#" class="btn btn-danger">Hapus</a>
      </div>
    </div>
  </div>
</div>


<script>
    function confirmDeleteQuiz(id) {
        $('#deleteQuizLink').attr('href', '<?= site_url("admin/delete_ujian/"); ?>' + id);
        $('#deleteQuizModal').modal('show');
    }
</script>