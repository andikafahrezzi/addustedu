<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Tambah Pertanyaan</h2>
                <hr>
                <form action="<?= base_url('kuisioner/tambah_pertanyaan/'.$kuisioner_id) ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                           value="<?= $this->security->get_csrf_hash(); ?>" />

                    <!-- Pertanyaan -->
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea name="pertanyaan" class="form-control" required></textarea>
                    </div>

                    <!-- Tipe Jawaban -->
                    <div class="form-group">
                        <label>Tipe Jawaban</label>
                        <select name="tipe_jawaban" id="tipe_jawaban" class="form-control" required>
                            <option value="skala">Skala (Likert 1–5)</option>
                            <option value="pilihan">Pilihan (Custom)</option>
                            <option value="text">Text (Isian Bebas)</option>
                        </select>
                    </div>

                    <!-- Skala -->
                    <div class="form-group" id="form-skala">
                        <label>Skala</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" name="skala_min" class="form-control" value="1">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="skala_max" class="form-control" value="5">
                            </div>
                        </div>
                        <small class="text-muted">Default: 1 = Sangat Tidak Setuju, 5 = Sangat Setuju</small>
                    </div>

                    <!-- Opsi Pilihan -->
                    <div class="form-group" id="form-opsi" style="display:none;">
                        <label>Opsi Pilihan</label>
                        <input type="text" name="opsi_pilihan" class="form-control" 
                               placeholder="Pisahkan dengan koma. Contoh: Ya,Tidak">
                        <small class="text-muted">Contoh lain: Sangat Puas,Puas,Cukup,Tidak Puas</small>
                    </div>

                    <!-- Urutan -->
                    <div class="form-group">
                        <label>Urutan</label>
                        <input type="number" name="urutan" class="form-control" value="0">
                    </div>

                    <button type="submit" class="btn btn-success">Simpan ⭢</button>
                    <a href="<?= base_url('kuisioner/pertanyaan/'.$kuisioner_id) ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Script Dinamis -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const tipeSelect = document.getElementById("tipe_jawaban");
    const formSkala = document.getElementById("form-skala");
    const formOpsi  = document.getElementById("form-opsi");

    function toggleFields() {
        let val = tipeSelect.value;
        if (val === "skala") {
            formSkala.style.display = "block";
            formOpsi.style.display  = "none";
        } else if (val === "pilihan") {
            formSkala.style.display = "none";
            formOpsi.style.display  = "block";
        } else { // text
            formSkala.style.display = "none";
            formOpsi.style.display  = "none";
        }
    }

    tipeSelect.addEventListener("change", toggleFields);
    toggleFields(); // run on load
});
</script>
