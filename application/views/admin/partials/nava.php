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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Dashboard - addustedu</title>
    <!-- General CSS Files -->
    <link rel="icon" href="<?= base_url('assets/') ?>img/logoh.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>stisla-assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/custom.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>stisla-assets/css/components.css">
    <script src="<?= base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
    

</head>

<body>

    <!-- Start Sidebar -->
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class=" navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
                        </li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" style="margin-bottom:4px !important;" src="<?php echo base_url().'/assets/stisla-assets/img/avatar/avatar-2.png';?>" class="rounded-circle mr-1 my-auto border-white">
                            <div class="d-sm-none d-lg-inline-block" style="font-size:15px;">Hello, <?php
                                                                                                $data['user'] = $this->db->get_where('admin', ['email' =>
                                                                                                $this->session->userdata('email')])->row_array();
                                                                                                echo $data['user']['username'];
                                                                                                ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Admin - addustedu</div>
                            <a href="<?= base_url('welcome/logout') ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand text-danger">
                        <div>
                            <a href="<?= base_url('admin') ?>" style="font-size: 30px;font-weight:900;font-family: 'Poppins', sans-serif;" class="text-success text-center"><i style="font-size: 30px;" class="fas fa-graduation-cap"></i> |
                                Addustedu <sup>3</sup></a>
                        </div>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="<?= base_url('admin') ?>">AE <sup>3</sup></a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header ">Dashboard</li>
                        <li class="nav-item dropdown active">
                            <a href="<?= base_url('admin') ?>" class="nav-link"><i class="fas fa-desktop"></i><span>Dashboard</span></a>
                        </li>
                        <li class="menu-header">Management Akademik</li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-calendar"></i>
                                <span>Akademik</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('admin/data_rps_admin') ?>">Data RPS Guru</a></li>
                                <li><a class="nav-link" href="<?= base_url('admin/kelas') ?>">Data Kelas</a></li>
                                <li><a class="nav-link" href="<?= base_url('admin/data_mapel') ?>">Data Mata Pelajaran</a>
                                    </li>
                            </ul>
                        </li>
                        <li class="menu-header">Management Siswa</li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user"></i>
                                <span>Siswa</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('admin/data_siswa') ?>">Data Siswa</a></li>
                                <li><a class="nav-link" href="<?= base_url('import') ?>">Import Data siswa</a>
                                    </li>
                            </ul>
                        </li>
                        <li class="menu-header">Management Guru</li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-chalkboard-teacher"></i>
                                <span>Guru</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('admin/data_guru') ?>">Data Guru</a>
                                </li>
                                <li><a class="nav-link" href="<?= base_url('admin/add_guru') ?>">Tambah Data Guru</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-header">Management Materi</li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i>
                                <span>Materi</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('admin/data_materi') ?>">Data Materi</a>
                                </li>
                                <li><a class="nav-link" href="<?= base_url('admin/data_pertemuan') ?>">Data Pertemuan</a>
                                <li><a class="nav-link" href="<?= base_url('admin/data_fordis') ?>">Data Fordis</a>
                                <li><a class="nav-link" href="<?= base_url('admin/data_ujian') ?>">Data Ujian</a>
                                <li><a class="nav-link" href="<?= base_url('admin/data_quiz') ?>">Data Quiz</a>
                                <li><a class="nav-link" href="<?= base_url('admin/bank_soal') ?>">Data Bank SOal</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-header">About Developer</li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-address-card"></i>
                                <span>Developer</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?= base_url('admin/about_developer') ?>">Tentang
                                        Pembuat</a>
                                </li>
                                <!-- <li><a class="nav-link" href="<?= base_url('admin/about_addustedu') ?>">Tentang
                                        addustedu</a>
                                </li> -->
                            </ul>
                        </li>
                </aside>
            </div>
            <!-- End Sidebar -->

            <!-- Main Content -->
            

            <!-- Start Footer -->
            
            <!-- End Footer -->

        </div>
    </div>
    <!-- End Main Content -->

    <!-- General JS Scripts -->
    