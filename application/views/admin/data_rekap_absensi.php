<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3>Export Rekap Absensi</h3>
                <hr>

                <form method="POST" action="<?= base_url('admin/export_rekap_absensi'); ?>">
<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                        value="<?= $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas_id" class="form-control" required>
                            <option value="">Pilih kelas</option>
                            <?php foreach($kelas_list as $k): ?>
                                <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mapel</label>
                        <select name="mapel_id" class="form-control" required>
                            <option value="">Pilih mapel</option>
                            <?php foreach($mapel_list as $m): ?>
                                <option value="<?= $m->id ?>"><?= $m->nama_mapel ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pertemuan dari</label>
                        <input type="number" name="start" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Pertemuan sampai</label>
                        <input type="number" name="end" class="form-control" required>
                    </div>

                    <button class="btn btn-primary">Export Excel</button>
                </form>

            </div>
        </div>
    </section>
</div>
