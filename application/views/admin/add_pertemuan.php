<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Dashboard - Ctkarya</title>

    <!-- General CSS Files -->
    <link rel="icon" href="<?= base_url('assets/') ?>img/logoh.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>stisla-assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/adminnavbar.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>stisla-assets/css/components.css">

    <style>
        body {
            background: #f9fdfa;
            font-family: 'Poppins', sans-serif;
        }

        .addust-logo {
            margin: 20px 0;
            text-align: center;
        }

        .addust-logo a {
            font-size: 26px;
            font-weight: bold;
            color: #28a745;
            text-decoration: none;
        }

        .addust-logo a:hover {
            text-decoration: underline;
            color: #218838;
        }

        form {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            max-width: 700px;
            margin: 30px auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        h1,
        label {
            color: #2d5f36;
        }

        .form-group {
            margin-bottom: 20px;
        }

        select.form-control,
        input.form-control {
            border-radius: 8px;
            border: 1px solid #c7e5d1;
            padding: 10px 14px;
            background: #fff;
            transition: all 0.3s ease;
        }

        select.form-control:focus,
        input.form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.2);
        }

        .btn-success {
            background: linear-gradient(to right, #00c851, #33b35a);
            border: none;
            font-weight: 600;
            border-radius: 30px;
            padding: 10px 24px;
            font-size: 16px;
            transition: 0.3s ease-in-out;
        }

        .btn-success:hover {
            background: #28a745;
            color: #fff;
        }

        .shortcut-button {
            margin-top: -10px;
        }
    </style>

    <script src="<?= base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>
</head>

<body>
    <!-- Navbar (jika ada, kamu bisa load partial navbar di sini) -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <ul class="navbar-nav navbar-right ml-auto">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="<?= base_url('assets/stisla-assets/img/avatar/avatar-2.png'); ?>" class="rounded-circle mr-1 border-white">
                    <div class="d-sm-none d-lg-inline-block">
                        Hello, <?= $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row()->username; ?>
                    </div>
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

    <!-- Logo dan Shortcut -->
    <div class="addust-logo text-center">
        <a href="<?= base_url('admin') ?>">
            <i class="fas fa-graduation-cap mr-1" style="font-size: 30px;"></i> Ctkarya <sup>3</sup>
        </a>
        <div class="shortcut-button mt-2">
            <a href="<?= base_url('admin/data_pertemuan') ?>" class="btn btn-outline-success btn-sm">
                <i class="fas fa-calendar-alt"></i> Lihat Data Pertemuan
            </a>
        </div>
    </div>

    <!-- Form Tambah Pertemuan -->
    <form method="post" action="<?= base_url('admin/add_pertemuan') ?>">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

        <div class="form-group">
            <label for="id_guru">Pilih Guru</label>
            <select name="id_guru" id="guru_select" class="form-control" required onchange="loadMateriByGuru(this.value)">
                <option value="">-- Pilih Guru --</option>
                <?php foreach ($guru as $g): ?>
                    <option value="<?= $g->nip ?>"><?= $g->nama_guru ?> (<?= $g->nip ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_materi">Pilih Materi</label>
            <select name="id_materi" id="materi_select" class="form-control" required>
                <option value="">-- Pilih Guru Dulu --</option>
            </select>
        </div>

        <div class="form-group">
            <label for="id_kelas">Pilih Kelas</label>
            <select name="id_kelas" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="pertemuan_ke">Pertemuan ke-</label>
            <input type="number" name="pertemuan_ke" class="form-control" required min="1">
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Pertemuan</button>
    </form>

    <!-- Script untuk Ajax load materi -->
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
