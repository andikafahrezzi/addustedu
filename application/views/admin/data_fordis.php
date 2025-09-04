<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Materi yang Sudah Dijadwalkan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url('admin') ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Materi Terjadwal</div>
            </div>
        </div>

        <div class="section-body">
                    <!-- SEARCH FORM -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="<?= site_url('admin/data_fordis'); ?>" method="get" class="form-inline">
                                    <input type="text" name="keyword" class="form-control mr-2 mb-2"
                                        placeholder="Cari guru, mapel, kelas, atau deskripsi..."
                                        value="<?= isset($filters['keyword']) ? html_escape($filters['keyword']) : ''; ?>">
                                    
                                    <select name="guru" class="form-control mr-2 mb-2">
                                        <option value="">-- Semua Guru --</option>
                                        <?php foreach ($guru_list as $guru): ?>
                                            <option value="<?= $guru->nip; ?>"
                                                <?= (isset($filters['guru']) && $filters['guru'] == $guru->nip) ? 'selected' : ''; ?>>
                                                <?= $guru->nama_guru; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    
                                    <select name="mapel" class="form-control mr-2 mb-2">
                                        <option value="">-- Semua Mapel --</option>
                                        <?php foreach ($mapel_list as $mapel): ?>
                                            <option value="<?= $mapel->id; ?>"
                                                <?= (isset($filters['mapel']) && $filters['mapel'] == $mapel->id) ? 'selected' : ''; ?>>
                                                <?= $mapel->nama_mapel; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    
                                    <select name="kelas" class="form-control mr-2 mb-2">
                                        <option value="">-- Semua Kelas --</option>
                                        <?php foreach ($kelas_list as $kelas): ?>
                                            <option value="<?= $kelas->id; ?>"
                                                <?= (isset($filters['kelas']) && $filters['kelas'] == $kelas->id) ? 'selected' : ''; ?>>
                                                <?= $kelas->nama_kelas; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    
                                    <button type="submit" name="submit" value="1" class="btn btn-primary mb-2">Cari</button>
                                    <a href="<?= site_url('admin/reset_search_fordis'); ?>" class="btn btn-secondary ml-2 mb-2">Reset</a>
                                </form>
                            </div>
                        </div>
<?php if (!empty($forums)): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr class="text-center bg-light">
                    <th>No</th>
                    <th>Guru</th>
                    <th>Mapel</th>
                    <th>Kelas</th>
                    <th>Pertemuan Ke</th>
                    <th>Deskripsi Materi</th>
                    <th>Total Komentar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($forums as $f): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $f->nama_guru ?></td>
                    <td><?= $f->nama_mapel ?></td>
                    <td><?= $f->nama_kelas ?></td>
                    <td class="text-center"><?= $f->pertemuan_ke ?></td>
                    <td><?= $f->deskripsi ?></td>
                    <td class="text-center"><?= $f->total_komentar ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('admin/delete_forum/'.$f->id_pertemuan) ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin ingin menghapus semua komentar di pertemuan ini?')">
                            <i class="fas fa-trash"></i> Hapus Forum
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mt-3">
                            <?= $pagination ?? '' ?>
        </div>
    </div>
<?php else: ?>
    <p class="text-muted">Belum ada pertemuan yang memiliki forum diskusi.</p>
<?php endif; ?>

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
<style>
.admin-forum-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
}

.admin-forum-table th, .admin-forum-table td {
  padding: 14px 18px;
  text-align: left;
  border-bottom: 1px solid #f0f0f0;
  vertical-align: top;
}

.admin-forum-table th {
  background: #f9fafc;
  font-weight: 600;
  font-size: 14px;
  color: #444;
}

.badge-mapel {
  background: linear-gradient(to right, #00c9ff, #92fe9d);
  color: #fff;
  font-size: 12px;
  font-weight: 500;
  padding: 4px 10px;
  border-radius: 20px;
  display: inline-block;
  margin-bottom: 4px;
}

.truncate-text {
  max-width: 300px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  font-size: 13px;
}

.guru-info {
  display: flex;
  align-items: center;
  font-size: 14px;
  color: #333;
}

.btn-outline-danger {
  color: #e74c3c;
  border: 1px solid #e74c3c;
  transition: 0.2s;
}

.btn-outline-danger:hover {
  background-color: #e74c3c;
  color: #fff;
}
</style>
