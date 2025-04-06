<div class="container mt-4">
    <div class="card shadow">
    <?php if($this->session->flashdata('timeout')): ?>
<div class="alert alert-warning">
    <?= $this->session->flashdata('timeout') ?>
    <?php if(isset($quiz->keterangan) && strpos($quiz->keterangan, 'Auto-submit') !== false): ?>
        <br><small>(Quiz diselesaikan secara otomatis)</small>
    <?php endif; ?>
</div>
<?php endif; ?>
        <div class="card-header bg-<?= $result->score >= 70 ? 'success' : 'danger' ?> text-white">
            <h4><i class="fas fa-clipboard-check mr-2"></i>Hasil Quiz: <?= $result->judul ?></h4>
        </div>
        
        <div class="card-body text-center">
            <div class="display-4 mb-3">
                Nilai Anda: <strong><?= number_format($result->score, 2) ?></strong>
            </div>
            
            <div class="progress mb-4" style="height: 30px;">
                <div class="progress-bar bg-<?= $result->score >= 70 ? 'success' : 'danger' ?>" 
                     role="progressbar" style="width: <?= $result->score ?>%" 
                     aria-valuenow="<?= $result->score ?>" aria-valuemin="0" aria-valuemax="100">
                    <?= number_format($result->score, 2) ?>%
                </div>
            </div>
            
            <p class="lead">
                <i class="fas fa fa-book mr-2"></i>Materi: <?= $result->nama_mapel ?>
            </p>
            <p class="lead">
                <i class="fas fa-calendar-alt mr-2"></i>
                Selesai pada: <?= date('d/m/Y H:i', strtotime($result->end_time)) ?>
            </p>
            
            <hr>
            
            <a href="<?= site_url('user') ?>" class="btn btn-primary">
                <i class="fas fa fa-arrow-left mr-2"></i>Kembali ke Daftar Quiz
            </a>
        </div>
    </div>
</div>