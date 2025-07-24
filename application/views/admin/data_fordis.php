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
            <?php if (!empty($materi_terjadwal)): ?>
                <?php foreach ($materi_terjadwal as $nama_guru => $tingkat_data): ?>
                    <div class="mt-4">
                        <h4>👨‍🏫 Guru: <?= $nama_guru ?></h4>

                        <?php foreach ($tingkat_data as $tingkat => $kelas_data): ?>
                            <h5 class="mt-3">🏫 Tingkat: <?= $tingkat ?></h5>

                            <?php foreach ($kelas_data as $nama_kelas => $list_materi): ?>
                                <h6 class="mt-2">📚 Kelas: <?= $nama_kelas ?></h6>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center bg-light">
                                                <th>ID</th>
                                                <th>Mata Pelajaran</th>
                                                <th>Pertemuan Ke</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list_materi as $m): ?>
                                                <tr>
                                                    <td class="text-center"><strong>#<?= $m->id ?></strong></td>
                                                    <td class="text-center"><?= $m->nama_mapel ?></td>
                                                    <td class="text-center"><?= $m->pertemuan_ke ?></td>
                                                    <td><?= $m->deskripsi ?></td>
                                                    <td class="text-center"><?= date('d-m-Y', strtotime($m->tanggal)) ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('admin/hapus_materi/'.$m->id) ?>"
                                                           class="btn btn-sm btn-outline-danger"
                                                           onclick="return confirm('Yakin ingin menghapus materi ini?')">
                                                           <i class="fas fa-trash-alt"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada materi yang dijadwalkan.</p>
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
