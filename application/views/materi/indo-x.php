
    <!-- Start Greeting Cards -->
    <div class="container">
        <div class="bg-white mt-25 p-5 buat-text" data-aos="fade-down" data-aos-duration="1400" style="width: 100%; border-radius:10px;">
            <div class="row" style="color: black; font-family: 'poppins';">
                <div class="col-md-12 mt-1 text-center">
                    <h1 class="display-4" data-aos="fade-down" data-aos-duration="1400">Silahkan pilih materi yang akan
                        kamu pelajari !
                    </h1>
                    <h4 data-aos="fade-down" data-aos-duration="1700"><?php
                                                                        $data['user'] = $this->db->get_where('siswa', ['nis' =>
                                                                        $this->session->userdata('nis')])->row_array();
                                                                        echo $data['user']['nama'];
                                                                        ?> - addustedu Students</h4>
                    <p>Bahasa Indonesia - Kelas X</p>
                    <hr width="80%">
                    <p data-aos="fade-down" class="font-weight-bold" data-aos-duration="1800">Silahkan pilih materi yang
                        akan kamu akses
                        dibawah
                        ini!
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Greeting Cards -->


    <!-- Start Lesson Cards -->
    <div class="container">
        <div class="row mt-4">
            <?php foreach ($materi as $u) { ?>
                <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-duration="1200">
                    <div class="card materi w-150 border-0">
                        <div class="card-body p-5">
                            <h1 class="card-title"><?= $u->nama_guru; ?></h1>
                            <p class=" card-text">
                                <?= substr($u->deskripsi, 0, 100); ?>&nbsp;.&nbsp;.&nbsp;.&nbsp;.&nbsp;.&nbsp;.&nbsp;.&nbsp;.
                            </p>
                            <a href="<?php echo site_url('materi/belajar/' . $u->id); ?>" class="btn btn-white">Pelajari
                                Sekarang !</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- End Lesson Cards -->


    <br>


    <!-- Start Animate On Scroll -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- End Animate On Scroll -->