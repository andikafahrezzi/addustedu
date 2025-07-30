
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title" style="color: black;">Management Data Siswa addustedu</h2>
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
                                    <table id="example" class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                                <th scope="col">ID</th>
                                                <th scope="col">Nama Siswa</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Gambar</th>
                                                <th scope="col">Akun Aktif *</th>
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
                                                        <?php echo $u->nis ?>
                                                    </th>

                                                    <td>
                                                        <?php echo $u->nama ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $u->email ?>
                                                    </td>

                                                    <td>
                                                        <img height="20px" src="<?= base_url() . 'assets/profile_picture/' . $u->image; ?>">
                                                    </td>

                                                    <td>
                                                        <?php echo $u->is_active ?>
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="<?php echo site_url('admin/detail_siswa/' . $u->nis); ?>" class="btn btn-success">Detail ⭢</a>
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="<?php echo site_url('admin/update_siswa/' . $u->nis); ?>" class="btn btn-info">Update ⭢</a>

                                                        <a href="<?php echo site_url('admin/delete_siswa/' . $u->nis); ?>" class="btn btn-danger remove">Delete ✖</a>
                                                    </td>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
        </div>
    </div>
    <!-- End Main Content -->

    <!-- Start Sweetalert -->

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>