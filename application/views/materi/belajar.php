

    <!-- Start Greeting Cards -->
    <div class="container">
        <div class="bg-white mt-25 p-5 buat-text" data-aos="fade-down" data-aos-duration="1400" style="width: 100%; border-radius:10px;">
            <div class="row" style="color: black; font-family: 'poppins';">
                <div class="col-md-12 mt-1 ml-4">
                    <h1 class="display-4" style="color: black; font-family:'poppins';" data-aos="fade-down" data-aos-duration="1400">Selamat Belajar !
                    </h1>
                    <h4 data-aos="fade-down" data-aos-duration="1700"><?php
                                                                        $data['user'] = $this->db->get_where('siswa', ['email' =>
                                                                        $this->session->userdata('email')])->row_array();
                                                                        echo $data['user']['nama'];
                                                                        ?> - addustedu Students</h3>
                        <p><?= $detail->nama_mapel ?> - Kelas <?= $detail->kelas ?></p>
                        <hr align="left" width="600;">
                        <p style="line-height: 3px;">Kita akan mempelajari tentang</p>
                        <p class="font-weight-bold mt--5">
                            <?= substr($detail->deskripsi, 0, 120); ?>

                        </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Greeting Cards -->


    <!-- Start Video Player -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 mx-auto mt-4">
                <video class="afterglow" autoplay id="myvideo" width="1280" height="720">
                    <source type="video/mp4" autoplay src="<?= base_url() . 'assets/materi_video/' . $detail->video; ?>" />
                </video>
            </div>
        </div>
    </div>
    <!-- End Video Player -->
    <!-- Start Deskripsi Materi -->
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12 w-150 mb-4">
                <div class="card materi border-0">
                    <div class="card-body p-5">
                        <h1 class="card-title display-4"><?= $detail->nama_guru; ?></h1>
                        <hr style="background-color: white;">
                        <h5 class="card-text"><?= $detail->nama_mapel; ?></h5>
                        <p class="card-text"> Deskripsi materi pelajaran : <br> <?= $detail->deskripsi; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Deskripsi Materi -->


    <br>


    <!-- Start Disqus Comment -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card komen w-150 border-0">
                    <div class="card-body p-5" style="font-family: 'Poppins', sans-serif !important;">
                        <h1 style="color: black; font-size:44px !important;">Apa komentarmu ?</h1>
                        <br>
                        <?php echo $disqus ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Disqus Comment -->


    <br>
    <br>
    <br>


    <!-- Start Animate On Scroll -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- End Animate On Scroll -->