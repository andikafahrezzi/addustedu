<!-- Main Content -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Dashboard - Ctkarya</title>
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
                            <div class="dropdown-title">Admin - Ctkarya</div>
                            <a href="<?= base_url('welcome/logout') ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
<div class="addust">
    <a href="<?= base_url('admin') ?>" class=" text-center"><i style="font-size: 30px;" class="fas fa-graduation-cap"></i> |
        Ctkarya <sup>3</sup></a>
</div>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0 text-white">
                <i class="fas fa-edit mr-2"></i>
                Edit Bank Soal
            </h4>
        </div>

        <div class="card-body">
            <?php if (validation_errors()): ?>
                <div class="alert alert-danger"><?= validation_errors() ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('admin/edit_bank_soal/'.$soal->id_soal) ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                       value="<?= $this->security->get_csrf_hash(); ?>" />

                <!-- Tipe Soal -->
                <div class="form-group">
                    <label for="tipe_soal">Tipe Soal *</label>
                    <select name="tipe_soal" id="tipe_soal" class="form-control" required>
                        <option value="">-- Pilih Tipe Soal --</option>
                        <option value="pilihan" <?= set_select('tipe_soal', 'pilihan', $soal->tipe_soal == 'pilihan') ?>>Pilihan Ganda</option>
                        <option value="essay" <?= set_select('tipe_soal', 'essay', $soal->tipe_soal == 'essay') ?>>Essay</option>
                    </select>
                    <?= form_error('tipe_soal', '<small class="text-danger">', '</small>') ?>
                </div>

                <!-- Pertanyaan -->
                <div class="form-group">
                    <label for="pertanyaan">Pertanyaan *</label>
                    <textarea name="pertanyaan" id="pertanyaan" class="form-control" rows="5" required><?= set_value('pertanyaan', $soal->pertanyaan) ?></textarea>
                    <?= form_error('pertanyaan', '<small class="text-danger">', '</small>') ?>
                </div>

                <!-- Pilihan Ganda -->
                <div id="pilihan-ganda-container" style="display:<?= $soal->tipe_soal == 'pilihan' ? 'block' : 'none' ?>;">
                    <div class="row">
                        <?php
                        $pilihan = ['a', 'b', 'c', 'd'];
                        foreach ($pilihan as $p):
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pilihan_<?= $p ?>">Pilihan <?= strtoupper($p) ?> *</label>
                                <input type="text" name="pilihan_<?= $p ?>" id="pilihan_<?= $p ?>" class="form-control"
                                    value="<?= set_value("pilihan_$p", $soal->{"pilihan_$p"}) ?>"
                                    <?= $soal->tipe_soal == 'pilihan' ? 'required' : '' ?>>
                                <?= form_error("pilihan_$p", '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Kunci Jawaban -->
                    <div class="form-group">
                        <label for="kunci_jawaban">Kunci Jawaban *</label>
                        <select name="kunci_jawaban" id="kunci_jawaban" class="form-control" <?= $soal->tipe_soal == 'pilihan' ? 'required' : '' ?>>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($pilihan as $p): ?>
                            <option value="<?= $p ?>" <?= set_select('kunci_jawaban', $p, $soal->kunci_jawaban == $p) ?>><?= strtoupper($p) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('kunci_jawaban', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <!-- Mata Pelajaran -->
                <div class="form-group">
                    <label for="mapel_diajarkan">Mata Pelajaran *</label>
                    <input type="text" class="form-control" value="<?= $soal->nama_mapel ?>" readonly disabled>
                    <input type="hidden" name="id_mapel" value="<?= $soal->id_mapel ?>">
                </div>

                <!-- Tingkat Kesulitan -->
                <div class="form-group">
                    <label for="tingkat_kesulitan">Tingkat Kesulitan</label>
                    <select name="tingkat_kesulitan" id="tingkat_kesulitan" class="form-control">
                        <option value="mudah" <?= set_select('tingkat_kesulitan', 'mudah', $soal->tingkat_kesulitan == 'mudah') ?>>Mudah</option>
                        <option value="sedang" <?= set_select('tingkat_kesulitan', 'sedang', $soal->tingkat_kesulitan == 'sedang') ?>>Sedang</option>
                        <option value="sulit" <?= set_select('tingkat_kesulitan', 'sulit', $soal->tingkat_kesulitan == 'sulit') ?>>Sulit</option>
                    </select>
                </div>

                <!-- Tipe Kognitif -->
                <div class="form-group">
                    <label for="tipe_kognitif">Tipe Kognitif</label>
                    <select name="tipe_kognitif" id="tipe_kognitif" class="form-control">
                        <?php
                        $kognitif = ['ingatan', 'paham', 'aplikasi', 'analisis', 'evaluasi', 'kreasi'];
                        foreach ($kognitif as $tk):
                        ?>
                        <option value="<?= $tk ?>" <?= set_select('tipe_kognitif', $tk, $soal->tipe_kognitif == $tk) ?>>
                            <?= ucfirst($tk) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update Soal</button>
                <a href="<?= site_url('admin/bank_soal') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<!-- JS untuk toggle -->
<script>
$(document).ready(function() {
    function togglePilihanGanda() {
        if ($('#tipe_soal').val() === 'pilihan') {
            $('#pilihan-ganda-container').show();
            $('#pilihan_a, #pilihan_b, #pilihan_c, #pilihan_d, #kunci_jawaban').prop('required', true);
        } else {
            $('#pilihan-ganda-container').hide();
            $('#pilihan_a, #pilihan_b, #pilihan_c, #pilihan_d, #kunci_jawaban').prop('required', false);
        }
    }

    togglePilihanGanda();

    $('#tipe_soal').change(function() {
        togglePilihanGanda();
    });
});
</script>
