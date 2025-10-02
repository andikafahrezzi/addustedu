<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card" style="width:100%;">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Pertanyaan untuk: <?= $kuisioner->judul ?></h2>
                <hr>
                <p class="card-text">Daftar pertanyaan yang termasuk dalam kuisioner ini.</p>
                <a href="<?= base_url('kuisioner/tambah_pertanyaan/'.$kuisioner->id) ?>" class="btn btn-success">Tambah Pertanyaan ⭢</a>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Pertanyaan</th>
                                    <th>Tipe</th>
                                    <th>Opsi/Skala</th>
                                    <th>Urutan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pertanyaan)): ?>
                                    <?php foreach ($pertanyaan as $p): ?>
                                        <tr class="text-center">
                                            <td><?= $p->id ?></td>
                                            <td><?= $p->pertanyaan ?></td>
                                            <td><?= ucfirst($p->tipe_jawaban) ?></td>
                                            <td>
                                                <?php if($p->tipe_jawaban == 'skala'): ?>
                                                    <?= $p->skala_min ?> - <?= $p->skala_max ?>
                                                <?php elseif($p->tipe_jawaban == 'pilihan'): ?>
                                                    <?= implode(", ", json_decode($p->opsi_pilihan)) ?>
                                                <?php else: ?>
                                                    Text
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $p->urutan ?></td>
                                            <td>
                                                <a href="<?= base_url('kuisioner/edit_pertanyaan/'.$p->id) ?>" class="btn btn-info btn-sm">Edit</a>
                                                <a href="<?= base_url('kuisioner/delete_pertanyaan/'.$p->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pertanyaan ini?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center">Belum ada pertanyaan</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
