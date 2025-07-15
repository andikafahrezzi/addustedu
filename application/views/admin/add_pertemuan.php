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
<form method="post" action="<?= base_url('admin/add_pertemuan') ?>">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
        value="<?= $this->security->get_csrf_hash(); ?>" />

    <!-- PILIH GURU -->
    <div class="form-group">
        <label for="nip_guru">Pilih Guru</label>
        <select name="nip_guru" id="guru_select" class="form-control" required onchange="loadMateriByGuru(this.value)">
            <option value="">-- Pilih Guru --</option>
            <?php foreach ($guru as $g): ?>
                <option value="<?= $g->nip ?>"><?= $g->nama_guru ?> (<?= $g->nip ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- PILIH MATERI -->
    <div class="form-group">
        <label for="id_materi">Pilih Materi</label>
        <select name="id_materi" id="materi_select" class="form-control" required>
            <option value="">-- Pilih Guru Dulu --</option>
            <!-- akan diisi via JavaScript -->
        </select>
    </div>

    <!-- PILIH KELAS -->
    <div class="form-group">
        <label for="id_kelas">Pilih Kelas</label>
        <select name="id_kelas" class="form-control" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($kelas as $k): ?>
                <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- PERTEMUAN -->
    <div class="form-group">
        <label for="pertemuan_ke">Pertemuan ke-</label>
        <input type="number" name="pertemuan_ke" class="form-control" required min="1">
    </div>

    <!-- TANGGAL -->
    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Simpan Pertemuan</button>
</form>

<script>
function loadMateriByGuru(nip) {
    if (!nip) {
        document.getElementById('materi_select').innerHTML = '<option value="">-- Pilih Guru Dulu --</option>';
        return;
    }

    fetch("<?= base_url('admin/get_materi_by_guru/') ?>" + nip)
        .then(response => response.json())
        .then(data => {
            let materiSelect = document.getElementById('materi_select');
            materiSelect.innerHTML = '';

            if (data.length > 0) {
                data.forEach(m => {
                    let option = document.createElement('option');
                    option.value = m.id;
                    option.text = m.deskripsi + " (" + m.nama_mapel + ")";
                    materiSelect.appendChild(option);
                });
            } else {
                materiSelect.innerHTML = '<option value="">Materi tidak ditemukan</option>';
            }
        });
}
</script>

