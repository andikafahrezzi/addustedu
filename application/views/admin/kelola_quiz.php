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
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4>
                <i class="fas fa-edit mr-2"></i>
                Kelola Quiz: <?= $quiz->judul ?>
                <small class="float-right">
                    Materi: <?= $quiz->materi->nama_mapel ?> - <?= $quiz->materi->nama_kelas ?>
                </small>
            </h4>
        </div>
        
        <div class="card-body">
            <!-- Form Tambah Soal -->
            <div class="mb-5">
                <h5><i class="fas fa-plus-circle mr-2"></i>Tambah Soal Baru</h5>
                <form method="post" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                value="<?= $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea name="pertanyaan" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Soal</label>
                                <select name="tipe" class="form-control" id="tipeSoal" required>
                                    <option value="pilihan">Pilihan Ganda</option>
                                    <option value="essay">Essay</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Poin</label>
                                <input type="number" name="poin" class="form-control" value="1" min="1" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Opsi untuk pilihan ganda -->
                    <div id="opsiPilihan">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Opsi A</label>
                                    <input type="text" name="opsi_a" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Opsi B</label>
                                    <input type="text" name="opsi_b" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Opsi C</label>
                                    <input type="text" name="opsi_c" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Opsi D</label>
                                    <input type="text" name="opsi_d" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jawaban Benar</label>
                            <select name="jawaban" class="form-control">
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Soal
                    </button>
                </form>
            </div>
            
            <!-- Daftar Soal -->
            <hr>
            <h5><i class="fas fa-list-ol mr-2"></i>Daftar Soal</h5>
            
            <?php if(empty($quiz->questions)): ?>
                <div class="alert alert-info">
                    Belum ada soal untuk quiz ini
                </div>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach($quiz->questions as $index => $soal): ?>
                    <div class="list-group-item mb-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">
                                <span class="badge badge-primary mr-2"><?= $index+1 ?></span>
                                <?= $soal->pertanyaan ?>
                                <small class="text-muted">(<?= strtoupper($soal->tipe) ?> - <?= $soal->poin ?> poin)</small>
                            </h6>
                            <div>
                                <a href="<?= site_url('admin/hapus_soal/'.$soal->id.'/'.$quiz->id) ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Hapus soal ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        
                        <?php if($soal->tipe == 'pilihan'): ?>
                        <div class="ml-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled 
                                       <?= $soal->jawaban == 'a' ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    A. <?= $soal->opsi_a ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled 
                                       <?= $soal->jawaban == 'b' ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    B. <?= $soal->opsi_b ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled 
                                       <?= $soal->jawaban == 'c' ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    C. <?= $soal->opsi_c ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" disabled 
                                       <?= $soal->jawaban == 'd' ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    D. <?= $soal->opsi_d ?>
                                </label>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Sembunyikan opsi pilihan jika tipe soal essay
document.getElementById('tipeSoal').addEventListener('change', function() {
    const opsiDiv = document.getElementById('opsiPilihan');
    if(this.value === 'essay') {
        opsiDiv.style.display = 'none';
    } else {
        opsiDiv.style.display = 'block';
    }
});
</script>