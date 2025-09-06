<form action="<?= site_url('pertemuan/simpan') ?>" method="post">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                        value="<?= $this->security->get_csrf_hash(); ?>" />
    <div class="form-group">
        <label>Pilih Mata Pelajaran *</label>
        <select name="id_mapel" id="id_mapel" class="form-control" required>
            <option value="">-- Pilih Mapel --</option>
            <?php foreach ($mapel_list as $mapel): ?>
                <option value="<?= $mapel->id ?>"><?= $mapel->nama_mapel ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Pilih Kelas *</label>
        <select name="id_kelas" id="id_kelas" class="form-control" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($kelas_list as $kelas): ?>
                <option value="<?= $kelas->id ?>"><?= $kelas->nama_kelas ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Pilih Materi *</label>
        <select name="id_materi" id="id_materi" class="form-control" required disabled>
            <option value="">-- Pilih Materi --</option>
            <?php foreach ($materi_list as $materi): ?>
                <option value="<?= $materi->id ?>" 
                        data-mapel="<?= $materi->id_mapel ?>" 
                        data-kelas="<?= $materi->id_kelas ?>">
                    <?= $materi->nama_mapel ?> - <?= $materi->nama_kelas ?>: <?= $materi->deskripsi ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Pertemuan Ke- *</label>
        <input type="number" name="pertemuan_ke" id="pertemuan_ke" class="form-control" value="1" min="1" required>
    </div>

    <div class="form-group">
        <label>Tanggal Pertemuan *</label>
        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Pertemuan</button>
    <a href="<?= site_url('pertemuan') ?>" class="btn btn-secondary">Batal</a>
</form>

<script>
const mapelSelect = document.getElementById('id_mapel');
const kelasSelect = document.getElementById('id_kelas');
const materiSelect = document.getElementById('id_materi');
const allMateriOptions = [...materiSelect.options]; // simpan semua opsi materi

function filterMateri() {
    const selectedMapel = mapelSelect.value;
    const selectedKelas = kelasSelect.value;

    materiSelect.innerHTML = '<option value="">-- Pilih Materi --</option>'; // reset
    let found = false;

    allMateriOptions.forEach(opt => {
        if (!opt.value) return;
        if (
            (!selectedMapel || opt.dataset.mapel === selectedMapel) &&
            (!selectedKelas || opt.dataset.kelas === selectedKelas)
        ) {
            materiSelect.appendChild(opt.cloneNode(true));
            found = true;
        }
    });

    materiSelect.disabled = !found;
}

mapelSelect.addEventListener('change', filterMateri);
kelasSelect.addEventListener('change', filterMateri);
</script>
