<h3>Soal dari Bank Soal</h3>
<?php foreach ($bank_soal as $s): ?>
    <div class="card mb-3">
        <div class="card-body">
            <strong><?= $s->pertanyaan ?></strong><br>
            A. <?= $s->pilihan_a ?><br>
            B. <?= $s->pilihan_b ?><br>
            C. <?= $s->pilihan_c ?><br>
            D. <?= $s->pilihan_d ?>
        </div>
    </div>
<?php endforeach; ?>

<h3>Soal Pribadi Guru</h3>
<?php foreach ($pribadi_soal as $s): ?>
    <div class="card mb-3">
        <div class="card-body">
            <strong><?= $s->pertanyaan ?></strong><br>
            A. <?= $s->pilihan_a ?><br>
            B. <?= $s->pilihan_b ?><br>
            C. <?= $s->pilihan_c ?><br>
            D. <?= $s->pilihan_d ?>
        </div>
    </div>
<?php endforeach; ?>

<a href="<?= site_url('guru/tambah_soal_ujian/'.$ujian_id) ?>" class="btn btn-primary">+ Tambah Soal Pribadi</a>
