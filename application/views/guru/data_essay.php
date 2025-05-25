<h3>Daftar Jawaban Essay Siswa</h3>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<?php foreach ($jawaban_essay as $jawaban): ?>
    <div class="card mb-3">
        <div class="card-header">
            <strong><?= $jawaban->nama_siswa ?></strong> (NIS: <?= $jawaban->nis ?>)
        </div>
        <div class="card-body">
            <p><strong>Pertanyaan:</strong> <?= htmlspecialchars($jawaban->pertanyaan) ?></p>
            <p><strong>Jawaban Siswa:</strong><br><?= nl2br(htmlspecialchars($jawaban->jawaban_essay)) ?></p>

            <!-- Tombol buka modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNilai<?= $jawaban->id_jawaban ?>">
                Beri Nilai
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalNilai<?= $jawaban->id_jawaban ?>" tabindex="-1" aria-labelledby="modalLabel<?= $jawaban->id_jawaban ?>" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="<?= site_url('guru/beri_nilai_essay') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <div class="modal-header">
              <h5 class="modal-title" id="modalLabel<?= $jawaban->id_jawaban ?>">Penilaian Jawaban Essay</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_jawaban" value="<?= $jawaban->id_jawaban ?>">

                <div class="form-group">
                    <label>Nilai (0-100)</label>
                    <input type="number" name="nilai_essay" class="form-control" required min="0" max="100"
                           value="<?= $jawaban->nilai_essay ?>">
                </div>
                <div class="form-group mt-2">
                    <label>Catatan</label>
                    <textarea name="catatan_essay" class="form-control"><?= $jawaban->catatan_essay ?></textarea>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
