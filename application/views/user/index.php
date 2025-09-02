<div class="container">
    <div class="bg-white mx-auto mt-5 p-4 buat-text" data-aos="fade-down" data-aos-duration="1400" style="width: 100%; border-radius:10px;">
        <div class="row" style="color: black; font-family: 'poppins';">
            <div class="col-md-12 mt-1">
                <h1 class="display-4" data-aos="fade-down" data-aos-duration="1400">
                    Selamat Datang di Cipta Tunas Karya<span style="font-size: 40px;">👋🏻</span>
                </h1>
                <p>Hello <?= $user['nama'] ?>, Ini merupakan halaman utama addustedu! Silahkan pilih kelas dan pelajari materi yang tersedia.</p>
                <h6 data-aos="fade-down" data-aos-duration="1800"><i class="fas fa fa-trophy"></i> Kelas <?= $user['nama_kelas'] ?> - Cipta Tunas Karya Students</h6>
            </div>
        </div>
    </div>

<h2 id="judul" class="text-center">Mata Pelajaran Kelas <?= $user['nama_kelas'] ?></h2>

   <?php 
// Persiapkan struktur pertemuan
$materi_pertemuan = [];
foreach ($pertemuan as $p) {
    $materi_pertemuan[$p['id_guru']][$p['id_mapel']][$p['pertemuan_ke']] = $p;
}
?>

<div class="accordion" id="mapelAccordion">
<?php foreach ($mapel_data as $nama_mapel => $guru_list): 
    $mapel_id = preg_replace('/\s+/', '', strtolower($nama_mapel));
?>
    <div class="card accordion-card shadow-sm">
        <div class="card-header" id="headingMapel<?= $mapel_id ?>">
            <button class="btn btn-link collapsed w-100 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseMapel<?= $mapel_id ?>">
                <h4 class="card-mapel mb-0"><?= $nama_mapel ?></h4>
                <i class="lnr lnr-chevron-down"></i>
            </button>
        </div>
        <div id="collapseMapel<?= $mapel_id ?>" class="collapse" data-parent="#mapelAccordion">
            <div class="card-body">
                <div class="row">
                <?php foreach ($guru_list as $nip => $mapel_guru): ?>
                    <?php foreach ($mapel_guru as $id_mapel => $materi_list): ?>
                        <?php 
                        $guru = $materi_list[0]['nama_guru'];
                        ?>
                        <div class="col-md-4">
                            <div class="guru-card" onclick="togglePertemuan(this)">
                                <div class="guru-avatar">
                                    <img src="<?= base_url('assets') ?>/assets/media/users/default.jpg" alt="Guru">
                                </div>
                                <h5 class="guru-nama"><?= $guru ?></h5>
                                <p>Klik untuk lihat pertemuan</p>
                            </div>
                        </div>

                        <div class="col-12 pertemuan-container d-none">
                            <div class="row mt-3">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="pertemuan-card h-100 shadow-sm">
                                            <div class="card-body">
                                                <h6>Pertemuan <?= $i ?></h6>
                                                <?php if (isset($materi_pertemuan[$nip][$id_mapel][$i])): 
                                                    $ptm = $materi_pertemuan[$nip][$id_mapel][$i]; ?>
                                                    <p><?= implode(' ', array_slice(explode(' ', $ptm['deskripsi_materi']), 0, 10)) ?>...</p>
                                                    <a href="<?= base_url('materi/belajar/' . $ptm['id']) ?>" class="btn btn-sm btn-gradient">
                                                        Pelajari <i class="lnr lnr-arrow-right"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <p><em>Materi belum tersedia</em></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <!-- UJIAN SECTION -->
                           <?php 
$ujian_list = $ujian_data[$nip][$id_mapel] ?? [];
?>
<?php if (!empty($ujian_list)): ?>
    <div class="row mt-4">
        <?php foreach ($ujian_list as $ujian): ?>
        <div class="col-md-4 mb-4">
            <div class="pertemuan-card h-100 shadow-sm" style="background: linear-gradient(135deg, #42e695, #3bb2b8);">
                <div class="card-body text-center text-white">
                    <h5 class="font-weight-bold text-dark"><?= $ujian['nama_ujian'] ?></h5>

                    <?php
                    $sudah_selesai = $this->db->get_where('tbl_jawaban_siswa', [
                        'nis' => $this->session->userdata('nis'),
                        'id_ujian' => $ujian['id_ujian'],
                        'is_selesai' => 1
                    ])->row();

                    $mulai = strtotime($ujian['tanggal_mulai'] . ' 00:00:00');
                    $selesai = strtotime($ujian['tanggal_selesai'] . ' 23:59:59');
                    $sekarang = time();
                    $status = $ujian['status']; // aktif atau nonaktif
                    ?>
                    <!-- ✅ Info deskripsi dinamis -->
                    <p>
                        <?php if ($sudah_selesai): ?>
                            Ujian telah diselesaikan.
                        <?php elseif ($status != 'aktif'): ?>
                            Ujian belum aktif.
                        <?php elseif ($sekarang < $mulai): ?>
                            Ujian belum dimulai.
                        <?php elseif ($sekarang > $selesai): ?>
                            Waktu ujian telah berakhir.
                        <?php else: ?>
                            Ujian tersedia.
                        <?php endif; ?>
                    </p>

                    <!-- Tombol dinamis -->
                    <?php if ($sudah_selesai): ?>
                        <button class="btn btn-sm btn-success" disabled>
                            <i class="lnr lnr-checkmark-circle"></i> Sudah Dikerjakan
                        </button>
                        <a href="<?= base_url('ujian/hasil/' . $ujian['id_ujian']) ?>" class="btn btn-sm btn-info mt-2">
                            Lihat Hasil <i class="lnr lnr-eye"></i>
                        </a>
                    <?php elseif ($status != 'aktif' || $sekarang < $mulai): ?>
                        <button class="btn btn-sm btn-secondary" disabled>
                            Belum bisa diakses
                        </button>
                    <?php elseif ($sekarang > $selesai): ?>
                        <button class="btn btn-sm btn-dark" disabled>
                            Waktu Habis
                        </button>
                    <?php else: ?>
                        <?php
                        // Cek apakah siswa sudah memulai tapi belum selesai
                        $jawaban_siswa = $this->db->get_where('tbl_jawaban_siswa', [
                            'nis' => $this->session->userdata('nis'),
                            'id_ujian' => $ujian['id_ujian'],
                            'is_selesai' => 0
                            ])->row();
                        ?>
                        <a href="<?= base_url('ujian/mulai/' . $ujian['id_ujian']) ?>" class="btn btn-sm btn-danger">
                            <?= $jawaban_siswa ? 'Lanjutkan Ujian' : 'Mulai Ujian' ?> <i class="lnr lnr-pencil"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p><em>Ujian belum tersedia</em></p>
<?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
                            </div>

<!-- Start Animate On Scroll -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

<script>
function togglePertemuan(el) {
    const row = el.closest('.row');
    const guruCol = el.closest('.col-md-4');
    const pertemuan = guruCol.nextElementSibling;

    const isActive = guruCol.classList.contains('active-guru');

    // Reset semua pertemuan dan style guru
    row.querySelectorAll('.pertemuan-container').forEach(p => p.classList.add('d-none'));
    row.querySelectorAll('.col-md-4').forEach(col => col.classList.remove('active-guru'));

    if (!isActive) {
        pertemuan.classList.remove('d-none');
        guruCol.classList.add('active-guru');
        window.scrollTo({ top: guruCol.offsetTop - 100, behavior: 'smooth' });
    }
}
</script>
<!-- End Animate On Scroll -->
