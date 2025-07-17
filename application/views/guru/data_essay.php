<style>
  .accordion-button {
    font-weight: 600;
    font-size: 16px;
    background-color: #f8f9fa;
    padding: 15px 20px;
    border: none;
    box-shadow: none;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .accordion-button:not(.collapsed) {
    background-color: #e7f3ff;
    color: #000;
  }

  .accordion-item {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    margin-bottom: 15px;
    overflow: hidden;
  }

  .accordion-body {
    background-color: #ffffff;
    padding: 20px;
    border-top: 1px solid #dee2e6;
  }

  .badge-status {
    font-size: 13px;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .badge-status.sudah {
    background-color: #d1e7dd;
    color: #0f5132;
  }

  .badge-status.belum {
    background-color: #ffe69c;
    color: #664d03;
  }

  .btn-outline-primary.btn-sm {
    margin-top: 10px;
  }
</style>

<h3 class="mb-4">Daftar Jawaban Essay Siswa</h3>

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php elseif ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<div class="accordion" id="accordionEssay">
  <?php foreach ($jawaban_essay as $index => $jawaban): ?>
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading<?= $index ?>">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse<?= $index ?>" aria-expanded="false"
                aria-controls="collapse<?= $index ?>">
          <span>
            <?= $jawaban->nama_siswa ?> (NIS: <?= $jawaban->nis ?>)
          </span>
          <span class="badge-status <?= $jawaban->nilai_essay !== null ? 'sudah' : 'belum' ?>">
            <i class="fas fa-<?= $jawaban->nilai_essay !== null ? 'check-circle' : 'clock' ?>"></i>
            <?= $jawaban->nilai_essay !== null ? 'Sudah Dinilai' : 'Belum Dinilai' ?>
          </span>
        </button>
      </h2>
      <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>"
           data-bs-parent="#accordionEssay">
        <div class="accordion-body">
          <p><strong>Pertanyaan:</strong><br><?= htmlspecialchars($jawaban->pertanyaan) ?></p>
          <p><strong>Jawaban Siswa:</strong><br><?= nl2br(htmlspecialchars($jawaban->jawaban_essay)) ?></p>

          <!-- Tombol buka modal -->
          <button type="button" class="btn btn-outline-primary btn-sm"
                  data-bs-toggle="modal" data-bs-target="#modalNilai<?= $jawaban->id_jawaban ?>">
            <i class="fas fa-pen"></i> Beri Nilai
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Penilaian -->
    <div class="modal fade" id="modalNilai<?= $jawaban->id_jawaban ?>" tabindex="-1"
         aria-labelledby="modalLabel<?= $jawaban->id_jawaban ?>" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="<?= site_url('guru/beri_nilai_essay') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                   value="<?= $this->security->get_csrf_hash() ?>">
            <input type="hidden" name="id_jawaban" value="<?= $jawaban->id_jawaban ?>">

            <div class="modal-header">
              <h5 class="modal-title">Penilaian Essay: <?= $jawaban->nama_siswa ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label>Nilai (0-100)</label>
                <input type="number" name="nilai_essay" class="form-control" required min="0" max="100"
                       value="<?= $jawaban->nilai_essay ?>">
              </div>
              <div class="mb-3">
                <label>Catatan</label>
                <textarea name="catatan_essay" class="form-control"
                          rows="3"><?= $jawaban->catatan_essay ?></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan Nilai</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
    // Tooltip aktivasi
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(t => new bootstrap.Tooltip(t));

    // Fitur pencarian nama siswa
    const inputFilter = document.getElementById('filterEssay');
    inputFilter.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.essay-item').forEach(function (item) {
            const nama = item.querySelector('.accordion-button').innerText.toLowerCase();
            item.style.display = nama.includes(keyword) ? '' : 'none';
        });
    });
</script>


<!-- Pastikan bootstrap JS sudah ada -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
