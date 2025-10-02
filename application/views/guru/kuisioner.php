<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;"><?= $kuisioner->judul ?></h2>
                <hr>
                <p><?= $kuisioner->deskripsi ?></p>

                <form action="<?= base_url('kuisioner_user/submit/'.$kuisioner->id) ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                           value="<?= $this->security->get_csrf_hash(); ?>" />

                    <?php foreach ($pertanyaan as $p): ?>
                        <div class="form-group">
                            <label><?= $p->pertanyaan ?></label>

                            <?php if ($p->tipe_jawaban == 'skala'): ?>
                                <?php for ($i=$p->skala_min; $i<=$p->skala_max; $i++): ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" 
                                               name="pertanyaan_<?= $p->id ?>" 
                                               value="<?= $i ?>" required>
                                        <label class="form-check-label"><?= $i ?></label>
                                    </div>
                                <?php endfor; ?>

                            <?php elseif ($p->tipe_jawaban == 'pilihan'): ?>
                                <?php foreach (json_decode($p->opsi_pilihan) as $opsi): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" 
                                               name="pertanyaan_<?= $p->id ?>" 
                                               value="<?= $opsi ?>" required>
                                        <label class="form-check-label"><?= $opsi ?></label>
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <textarea name="pertanyaan_<?= $p->id ?>" class="form-control" required></textarea>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-success">Kirim Jawaban ⭢</button>
                </form>
            </div>
        </div>
    </section>
</div>
