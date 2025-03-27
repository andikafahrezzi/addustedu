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
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Materi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url('admin') ?>">Dashboard</a></div>
                <div class="breadcrumb-item">List Materi</div>
            </div>
        </div>

        <div class="section-body">
            <div class="table-responsive-container">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Guru</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($materi as $m): ?>
                            <tr>
                                <td><?= $m->id ?></td>
                                <td><?= $m->nama_mapel ?></td>
                                <td>Kelas <?= $m->kelas ?></td>
                                <td><?= $m->nama_guru ?></td>
                                <td class="truncate-text" title="<?= htmlspecialchars($m->deskripsi) ?>">
                                    <?= substr(strip_tags($m->deskripsi), 0, 100) ?>
                                    <?= strlen($m->deskripsi) > 100 ? '...' : '' ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/hapus_forum/'.$m->id) ?>" 
                                       class="btn-table-action btn-danger"
                                       onclick="return confirm('Yakin hapus semua diskusi materi ini?')">
                                       <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    // Dropdown Functionality - Vanilla JS
document.addEventListener('DOMContentLoaded', function() {
    // Get all dropdown toggles
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    // Close all dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            closeAllDropdowns();
        }
    });

    // Add click event to each dropdown toggle
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const parentDropdown = this.closest('.dropdown');
            const menu = parentDropdown.querySelector('.dropdown-menu');
            
            // Close all other dropdowns first
            closeAllDropdowns(parentDropdown);
            
            // Toggle current dropdown
            parentDropdown.classList.toggle('show');
            menu.classList.toggle('show');
        });
    });

    // Function to close all dropdowns except the one passed as parameter
    function closeAllDropdowns(exceptThis = null) {
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            if (dropdown !== exceptThis) {
                dropdown.classList.remove('show');
                const menu = dropdown.querySelector('.dropdown-menu');
                if (menu) menu.classList.remove('show');
            }
        });
    }
});
</script>