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

<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= base_url('assets/') ?>img/favicon.png" type="image/png">
    <!-- Title -->
    <title>Selamat datang - <?php
                            $data['user'] = $this->db->get_where('siswa', ['nis' =>
                            $this->session->userdata('nis')])->row_array();
                            echo $data['user']['nama'];
                            ?> - addustedu Student Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendors/linericon/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendors/lightbox/simpleLightbox.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendors/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendors/animate-css/animate.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendors/popup/magnific-popup.css">
    <!-- Main css -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/user_style.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/responsive.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.4/dist/sweetalert2.all.min.js"></script>

</head>

<body style="overflow-x:hidden;background-color:#fbf9fa">


    <!-- Start Navigation Bar -->
    
    <!-- End Navigation Bar -->


    <!-- Start Greetings Card -->
    <div class="container">
        <div class="bg-white mx-auto mt-5 p-4 buat-text" data-aos="fade-down" data-aos-duration="1400" style="width: 100%; border-radius:10px;">
            <div class="row" style="color: black; font-family: 'poppins';">
                <div class="col-md-12 mt-1">
                    <h1 class="display-4" style="color: black; font-family:'poppins';" data-aos="fade-down" data-aos-duration="1400">Selamat Datang
                        di addustedu <span style="font-size: 40px;">👋🏻
                        </span> </h1>
                    <p>Hello Studentss! , Ini merupakan halaman utama addustedu ! Silahkan pilih kelas yang akan kamu
                        akses
                        dan pilih mata pelajaran yang ingin kamu pelajari. Selamat belajar ya students!</p>
                    <hr>
                    <h4 style="line-height: 4px;" data-aos="fade-down" data-aos-duration="1700"> Hai, <?php
                                                                                                $data['user'] = $this->db->get_where('siswa', ['nis' =>
                                                                                                $this->session->userdata('nis')])->row_array();
                                                                                                echo $data['user']['nama'];
                                                                                                ?> </h4>
                        <p data-aos="fade-down" data-aos-duration="1800">Kelas, <?php
                                                                                                $data['user'] = $this->db->get_where('siswa', ['nis' =>
                                                                                                $this->session->userdata('nis')])->row_array();
                                                                                                echo $data['user']['kelas'];
                                                                                                ?> - addustedu Students</h4>
                        
                        
                </div>
            </div>
        </div>
    </div>
    <!-- End Greetings Card -->

    <?php $data['materi'] = $this->db->get_where('materi', ['kelas' => $kelas_siswa])->result_array();?>
    <br>




    <!-- Start Class Card -->
<?php
$materi_per_mapel = [];

foreach ($data['materi'] as $m) {
    $materi_per_mapel[$m['nama_mapel']][] = $m;
}
?>

<?php if (isset($kelas_siswa) && !empty($kelas_siswa)) { ?>
    <div class="container">
        <h2 class="text-center" id="judul">Mata Pelajaran Kelas <?= $kelas_siswa ?></h2>
        <div class="row mt-4 mb-5 justify-content-center">
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    <?php foreach ($materi_per_mapel as $mapel => $materi_list) { 
                        $mapel_id = preg_replace('/\s+/', '', strtolower($mapel)); // Buat ID unik dari nama mapel
                    ?>
                        <div class="card mb-3">
                            <div class="card-header" id="heading<?= $mapel_id ?>">
                                <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $mapel_id ?>" aria-expanded="false" aria-controls="collapse<?= $mapel_id ?>">
                                    <h3 class="mb-0"><?= $mapel ?></h3>
                                    <i class="lnr lnr-chevron-down float-right"></i>
                                </button>
                            </div>
                            <div id="collapse<?= $mapel_id ?>" class="collapse" aria-labelledby="heading<?= $mapel_id ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($materi_list as $m) { ?>
                                            <div class="col-md-4 mb-4">
                                                <div class="card materi-card shadow-lg h-100">
                                                    <div class="card-img-container">
                                                        <a href="<?= base_url('materi/belajar/' . $m['id']) ?>" >
                                                            <img src="<?= base_url('assets/img/' . $m['nama_mapel'] . '.png') ?>" 
                                                                class="card-img-top" 
                                                                alt="<?= $m['nama_mapel'] ?>"
                                                                onerror="this.src='<?= base_url('assets/img/default-subject.png') ?>'">
                                                            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                                                            <a href="<?= base_url('materi/belajar/' . $m['id']) ?>" 
                                                                    class="btn badge badge-pill badge-primary">
                                                                        Pelajari <i class="lnr lnr-arrow-right"></i>
                                                                    </a>
                                                            </div>
                                                    </a>
                                                    </div>
                                                    <div class="card-body d-flex flex-column">
                                                        <h5 class="card-title text-truncate"><?= $m['nama_mapel'] ?></h5>
                                                        <div class="card-text flex-grow-1">
                                                            <?= implode(' ', array_slice(explode(' ', $m['deskripsi']), 0, 10)) ?>
                                                            <?php if (str_word_count($m['deskripsi']) > 10): ?>
                                                                <span class="text-muted">...</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="mt-auto">
                                                            <hr class="divider">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="teacher-badge">
                                                                    <i class="fas fa-chalkboard-teacher mr-1"></i>
                                                                    <?= $m['nama_guru'] ?>
                                                                </span>
                                                                <a href="<?= base_url('materi/belajar/' . $m['id']) ?>" 
                                                                class="btn btn-sm btn-outline-primary">
                                                                    Pelajari <i class="lnr lnr-arrow-right"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>                            
                                </div>
                            </div>


                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <p class="text-center">Kelas siswa tidak ditemukan.</p>
<?php } ?>

    <!-- End Class Card -->


    <br>


    <!-- Start Animate On Scroll -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- End Animate On Scroll -->