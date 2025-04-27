<div class="container">
    <h2>Tambah Soal untuk Ujian</h2>
    <form method="post" action="<?= site_url('guru/simpan_soal') ?>">
        <input type="hidden" name="id_ujian" value="<?= $id_ujian ?>">
        <div class="form-group">
            <label for="pertanyaan">Pertanyaan</label>
            <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="pilihan_a">Pilihan A</label>
            <input type="text" class="form-control" id="pilihan_a" name="pilihan_a" required>
        </div>
        <div class="form-group">
            <label for="pilihan_b">Pilihan B</label>
            <input type="text" class="form-control" id="pilihan_b" name="pilihan_b" required>
        </div>
        <div class="form-group">
            <label for="pilihan_c">Pilihan C</label>
            <input type="text" class="form-control" id="pilihan_c" name="pilihan_c" required>
        </div>
        <div class="form-group">
            <label for="pilihan_d">Pilihan D</label>
            <input type="text" class="form-control" id="pilihan_d" name="pilihan_d" required>
        </div>
        <div class="form-group">
            <label for="kunci_jawaban">Kunci Jawaban</label>
            <select class="form-control" id="kunci_jawaban" name="kunci_jawaban" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Soal</button>
    </form>
</div>
