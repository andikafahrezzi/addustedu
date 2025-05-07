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
            
            <form method="post" action="<?= site_url('admin/add_quiz') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
            value="<?= $this->security->get_csrf_hash(); ?>" />
                <div class="form-group">
                    <label for="materi_id"><i class="fas fa-book mr-1"></i> Pilih Materi</label>
                    <select name="materi_id" id="materi_id" class="form-control" required>
                        <option value="">-- Pilih Materi --</option>
                        <?php foreach($materi_list as $materi): ?>
                        <option value="<?= $materi->id ?>" <?= set_select('materi_id', $materi->id) ?>>
                            <?= $materi->nama_mapel ?> - <?= $materi->kelas ?> (<?= $materi->nama_guru ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="judul"><i class="fas fa-heading mr-1"></i> Judul Quiz</label>
                    <input type="text" name="judul" id="judul" class="form-control" 
                           value="<?= set_value('judul') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi"><i class="fas fa-align-left mr-1"></i> Deskripsi Quiz</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"
                              ><?= set_value('deskripsi') ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="waktu_pengerjaan">
                                <i class="fas fa-clock mr-1"></i> Waktu Pengerjaan (menit)
                            </label>
                            <input type="number" name="waktu_pengerjaan" id="waktu_pengerjaan" 
                                   class="form-control" value="<?= set_value('waktu_pengerjaan', 30) ?>" 
                                   min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="attempts">
                                <i class="fas fa-redo mr-1"></i> Percobaan Maksimal
                            </label>
                            <input type="number" name="attempts" id="attempts" 
                                   class="form-control" value="<?= set_value('attempts', 1) ?>" 
                                   min="1" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="shuffle_questions" 
                               name="shuffle_questions" value="1" <?= set_checkbox('shuffle_questions', '1', true) ?>>
                        <label class="custom-control-label" for="shuffle_questions">
                            Acak urutan soal
                        </label>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-save mr-2"></i> Simpan Quiz
                    </button>
                    <a href="<?= site_url('admin') ?>" class="btn btn-secondary btn-lg px-4 ml-2">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>