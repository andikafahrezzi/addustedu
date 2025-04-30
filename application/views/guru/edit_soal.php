<div class="container">
    <h2>Edit Soal Ujian</h2>
    <form action="<?= site_url('guru/edit_soal/' . $soal['id_soal']) ?>" method="post">
        <div class="form-group">
            <label>Soal</label>
            <textarea name="pertanyaan" class="form-control" required><?= $soal['pertanyaan'] ?></textarea>
        </div>
        <div class="form-group">
            <label>Jawaban A</label>
            <input type="text" name="pilihan_a" class="form-control" required value="<?= $soal['pilihan_a'] ?>">
        </div>
        <div class="form-group">
            <label>Jawaban B</label>
            <input type="text" name="pilihan_b" class="form-control" required value="<?= $soal['pilihan_b'] ?>">
        </div>
        <div class="form-group">
            <label>Jawaban C</label>
            <input type="text" name="pilihan_c" class="form-control" required value="<?= $soal['pilihan_c'] ?>">
        </div>
        <div class="form-group">
            <label>Jawaban D</label>
            <input type="text" name="pilihan_d" class="form-control" required value="<?= $soal['pilihan_d'] ?>">
        </div>
        <div class="form-group">
            <label>Jawaban Benar</label>
            <select name="kunci_jawaban" class="form-control" required>
                <option value="A" <?= $soal['kunci_jawaban'] == 'A' ? 'selected' : '' ?>>A</option>
                <option value="B" <?= $soal['kunci_jawaban'] == 'B' ? 'selected' : '' ?>>B</option>
                <option value="C" <?= $soal['kunci_jawaban'] == 'C' ? 'selected' : '' ?>>C</option>
                <option value="D" <?= $soal['kunci_jawaban'] == 'D' ? 'selected' : '' ?>>D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Soal</button>
    </form>
</div>
