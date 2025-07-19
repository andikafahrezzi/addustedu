<!--
@Project: addustedu
@Programmer: Syauqi Zaidan Khairan Khalaf
@Website: https://linktr.ee/syauqi
@Email : syaokay@gmail.com

@About-addustedu :
Web Edukasi Open Source yang dibuat oleh Syauqi Zaidan Khairan Khalaf.
addustedu adalah Web edukasi yang dilengkapi video, materi dan sistem ujian
yang tersedia secara gratis. addustedu dibuat ditujukan agar para siswa dan
guru dapat terus belajar dan mengajar dimana saja dan kapan saja.
-->


            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="card" style="width:100%;">
                        <div class="card-body">
                            <h2 class="card-title" style="color: black;">Management Data Guru addustedu</h2>
                            <hr>
                            <p class="card-text"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction. </p>
                            <a href="<?= base_url('admin/add_guru') ?>" class="btn btn-success">Tambah
                                Data Guru ⭢</a>
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                                <div class="table-responsive">
                                    <table id="example" class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                                <th scope="col">NIP</th>
                                                <th scope="col">Nama Guru</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Nama Mapel</th>
                                                <th scope="col">Detail</th>
                                                <th scope="col">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            foreach ($user as $u) {
                                            ?>
                                                <tr class="text-center">

                                                    <th scope="row">
                                                        <?php echo $u->nip ?>
                                                    </th>

                                                    <td>
                                                        <?php echo $u->nama_guru ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $u->email ?>
                                                    </td>


                                                    <td>
                                                        <?php echo $u->mapel_diajar ?? '-' ?>

                                                    </td>

                                                    <td class="text-center">
                                                        <a href="<?php echo site_url('admin/detail_guru/' . $u->nip); ?>" class="btn btn-success">Detail ⭢</a>
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="<?php echo site_url('admin/update_guru/' . $u->nip); ?>" class="btn btn-info">Update ⭢</a>

                                                        <a href="<?php echo site_url('admin/delete_guru/' . $u->nip); ?>" class="btn btn-danger remove">Delete ✖</a>
                                                    </td>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <p class="small font-weight-bold">Pendaftaran guru hanya dapat dilakukan admin dan tidak bisa dilakukan sendiri</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

   

   
    <!-- End Footer -->

    <!-- General JS Scripts -->
   
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <!-- Template JS File -->