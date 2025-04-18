<div class="container">
    <div class="bg-white mx-auto mt-5 p-4 buat-text" data-aos="fade-down" data-aos-duration="1400" style="width: 100%; border-radius:10px;">
        <div class="row" style="color: black; font-family: 'poppins';">
            <div class="col-md-12 mt-1">
                <h1 class="display-4" data-aos="fade-down" data-aos-duration="1400">Selamat Datang di addustedu <span style="font-size: 40px;">👋🏻</span></h1>
                <p>Hello <?= $user['nama'] ?>, Ini merupakan halaman utama addustedu! Silahkan pilih kelas dan pelajari materi yang tersedia.</p>
                <h6 data-aos="fade-down" data-aos-duration="1800"><i class="fas fa fa-trophy"></i> Kelas <?= $user['kelas'] ?> - addustedu Students</h6>
            </div>
        </div>
    </div>

    < <h2 id="judul" class="text-center">Mata Pelajaran Kelas <?= $kelas_siswa ?></h2>

<div class="accordion" id="mapelAccordion">
  <?php foreach ($mapel_data as $mapel => $guru_list): 
    $mapel_id = preg_replace('/\s+/', '', strtolower($mapel));
  ?>
    <div class="card accordion-card shadow-sm">
      <div class="card-header" id="headingMapel<?= $mapel_id ?>">
        <button class="btn btn-link collapsed w-100 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#collapseMapel<?= $mapel_id ?>">
          <h4 class="card-mapel mb-0"><?= $mapel ?></h4>
          <i class="lnr lnr-chevron-down"></i>
        </button>
      </div>
      <div id="collapseMapel<?= $mapel_id ?>" class="collapse" data-parent="#mapelAccordion">
        <div class="card-body">
          <div class="row">
            <?php foreach ($guru_list as $guru => $materi_list): ?>
                <div class="col-md-4">
                <div class="guru-card" onclick="togglePertemuan(this)">
                    <div class="guru-avatar">
                    <img src="<?=base_url('assets')?>/assets/media/users/default.jpg" /> alt="Guru">
                    </div>
                    <h5 class="guru-nama"><?= $guru ?></h5>
                    <p>Klik untuk lihat pertemuan</p>
                </div>
                </div>

              <div class="col-12 pertemuan-container d-none">
                <div class="row mt-3">
                  <?php 
                    $materi_pertemuan = [];
                    foreach ($materi_list as $materi) {
                      $materi_pertemuan[$materi['pertemuan']] = $materi;
                    }

                    for ($i = 1; $i <= 10; $i++): ?>
                    <div class="col-md-4 mb-4">
                      <div class="pertemuan-card h-100 shadow-sm">
                        <div class="card-body">
                          <h6>Pertemuan <?= $i ?></h6>
                          <?php if (isset($materi_pertemuan[$i])): ?>
                            <p><?= implode(' ', array_slice(explode(' ', $materi_pertemuan[$i]['deskripsi']), 0, 10)) ?>...</p>
                            <a href="<?= base_url('materi/belajar/' . $materi_pertemuan[$i]['id']) ?>" class="btn btn-sm btn-gradient">
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
              </div>
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
$(document).ready(function () {
    $('.mapel-card').on('click', function () {
        const mapelId = $(this).data('mapel');
        const mapelName = $(this).find('.card-title').text();
        const guruList = mapelData[mapelName];

        $('#selected-mapel-title').text("Pilih Guru untuk " + mapelName);
        $('#guru-list').empty();
        $('#pertemuan-container').hide();

        for (let guru in guruList) {
            $('#guru-list').append(`
                <div class="col-md-4 mb-3">
                    <div class="card guru-card shadow-sm" data-guru="${guru}" data-mapel="${mapelName}">
                        <div class="card-body text-center">
                            <strong>${guru}</strong>
                        </div>
                    </div>
                </div>
            `);
        }

        $('#guru-container').show();
    });

    // Saat klik guru
    $(document).on('click', '.guru-card', function () {
        const guruName = $(this).data('guru');
        const mapelName = $(this).data('mapel');
        const materiList = mapelData[mapelName][guruName];

        $('#selected-guru-title').text("Pertemuan dengan " + guruName);
        $('#pertemuan-list').empty();

        let materiPertemuan = {};
        materiList.forEach(m => {
            materiPertemuan[m.pertemuan] = m;
        });

        for (let i = 1; i <= 10; i++) {
            const materi = materiPertemuan[i];
            let card = `
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Pertemuan ${i}</h5>
            `;

            if (materi) {
                const deskripsi = materi.deskripsi.split(" ").slice(0, 10).join(" ") + '...';
                card += `
                    <p>${deskripsi}</p>
                    <a href="${'<?= base_url("materi/belajar/") ?>' + materi.id}" class="btn btn-sm btn-primary">
                        Pelajari <i class="lnr lnr-arrow-right"></i>
                    </a>
                `;
            } else {
                card += `<p><em>Materi belum tersedia</em></p>`;
            }

            card += `</div></div></div>`;
            $('#pertemuan-list').append(card);
        }

        $('#pertemuan-container').show();
    });
});
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