<!-- Main Content -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Dashboard - addustedu</title>
    <!-- General CSS Files -->
    <link rel="icon" href="<?= base_url('assets/') ?>img/logoh.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>stisla-assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/adminnavbar.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>stisla-assets/css/components.css">
    <script src="<?= base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>
</head>

<body>
<div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
           
        </div>
    </div>

<nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <
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
<div class="addust">
    <a href="<?= base_url('admin') ?>" class=" text-center"><i style="font-size: 30px;" class="fas fa-graduation-cap"></i> |
        Addustedu <sup>3</sup></a>
</div>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-plus-circle mr-2"></i>
                Buat Quiz Baru
            </h4>
        </div>
        
        <div class="card-body">
            <?php if(validation_errors()): ?>
                <div class="alert alert-danger">
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>
            <div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="<?= site_url('admin/add_bank_soal') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
            value="<?= $this->security->get_csrf_hash(); ?>" />
                <!-- Tipe Soal -->
                <div class="form-group">
                    <label for="tipe_soal">Tipe Soal *</label>
                    <select name="tipe_soal" id="tipe_soal" class="form-control" required>
                        <option value="">-- Pilih Tipe Soal --</option>
                        <option value="pilihan" <?= set_select('tipe_soal', 'pilihan') ?>>Pilihan Ganda</option>
                        <option value="essay" <?= set_select('tipe_soal', 'essay') ?>>Essay</option>
                    </select>
                    <?= form_error('tipe_soal', '<small class="text-danger">', '</small>') ?>
                </div>

                <!-- Pertanyaan -->
                <div class="form-group">
                    <label for="pertanyaan">Pertanyaan *</label>
                    <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="5" required><?= set_value('pertanyaan') ?></textarea>
                    <?= form_error('pertanyaan', '<small class="text-danger">', '</small>') ?>
                </div>
                
                <!-- Pilihan Jawaban (Hanya untuk Pilihan Ganda) -->
                <div id="pilihan-ganda-container" style="display:none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_a">Pilihan A *</label>
                                <input type="text" name="pilihan_a" id="pilihan_a" class="form-control" value="<?= set_value('pilihan_a') ?>">
                                <?= form_error('pilihan_a', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_b">Pilihan B *</label>
                                <input type="text" name="pilihan_b" id="pilihan_b" class="form-control" value="<?= set_value('pilihan_b') ?>">
                                <?= form_error('pilihan_b', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_c">Pilihan C *</label>
                                <input type="text" name="pilihan_c" id="pilihan_c" class="form-control" value="<?= set_value('pilihan_c') ?>">
                                <?= form_error('pilihan_c', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_d">Pilihan D *</label>
                                <input type="text" name="pilihan_d" id="pilihan_d" class="form-control" value="<?= set_value('pilihan_d') ?>">
                                <?= form_error('pilihan_d', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kunci Jawaban -->
                    <div class="form-group">
                        <label for="kunci_jawaban">Kunci Jawaban *</label>
                        <select name="kunci_jawaban" id="kunci_jawaban" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="a" <?= set_select('kunci_jawaban', 'a') ?>>A</option>
                            <option value="b" <?= set_select('kunci_jawaban', 'b') ?>>B</option>
                            <option value="c" <?= set_select('kunci_jawaban', 'c') ?>>C</option>
                            <option value="d" <?= set_select('kunci_jawaban', 'd') ?>>D</option>
                        </select>
                        <?= form_error('kunci_jawaban', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <!-- Mata Pelajaran -->
                <div class="form-group">
                    <label for="mapel_diajarkan">Mata Pelajaran *</label>
                    <input type="text" name="mapel_diajarkan" id="mapel_diajarkan" class="form-control" required>
                </div>
                
                <!-- Tingkat Kesulitan -->
                <div class="form-group">
                    <label for="tingkat_kesulitan">Tingkat Kesulitan</label>
                    <select name="tingkat_kesulitan" id="tingkat_kesulitan" class="form-control">
                        <option value="mudah" <?= set_select('tingkat_kesulitan', 'mudah') ?>>Mudah</option>
                        <option value="sedang" <?= set_select('tingkat_kesulitan', 'sedang', TRUE) ?>>Sedang</option>
                        <option value="sulit" <?= set_select('tingkat_kesulitan', 'sulit') ?>>Sulit</option>
                    </select>
                </div>
                
                <!-- Tipe Kognitif -->
                <div class="form-group">
                    <label for="tipe_kognitif">Tipe Kognitif</label>
                    <select name="tipe_kognitif" id="tipe_kognitif" class="form-control">
                        <option value="ingatan" <?= set_select('tipe_kognitif', 'ingatan') ?>>Ingatan</option>
                        <option value="paham" <?= set_select('tipe_kognitif', 'paham', TRUE) ?>>Pemahaman</option>
                        <option value="aplikasi" <?= set_select('tipe_kognitif', 'aplikasi') ?>>Aplikasi</option>
                        <option value="analisis" <?= set_select('tipe_kognitif', 'analisis') ?>>Analisis</option>
                        <option value="evaluasi" <?= set_select('tipe_kognitif', 'evaluasi') ?>>Evaluasi</option>
                        <option value="kreasi" <?= set_select('tipe_kognitif', 'kreasi') ?>>Kreasi</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Soal</button>
                <a href="<?= site_url('guru/bank_soal') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan/sembunyikan pilihan ganda
    function togglePilihanGanda() {
        if ($('#tipe_soal').val() === 'pilihan') {
            $('#pilihan-ganda-container').show();
            // Buat field required
            $('#pilihan-a, #pilihan-b, #pilihan-c, #pilihan-d, #kunci_jawaban').prop('required', true);
        } else {
            $('#pilihan-ganda-container').hide();
            // Hilangkan required
            $('#pilihan-a, #pilihan-b, #pilihan-c, #pilihan-d, #kunci_jawaban').prop('required', false);
        }
    }

    // Jalankan saat halaman dimuat
    togglePilihanGanda();
    
    // Jalankan saat tipe soal berubah
    $('#tipe_soal').change(function() {
        togglePilihanGanda();
    });

    // Jika ada error validasi, pastikan tampilan sesuai
    <?php if (form_error('pilihan_a') || form_error('pilihan_b') || form_error('pilihan_c') || form_error('pilihan_d') || form_error('kunci_jawaban')): ?>
        $('#tipe_soal').val('pilihan').trigger('change');
    <?php endif; ?>
});
</script>