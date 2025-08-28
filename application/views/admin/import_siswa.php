<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;">Import Data Siswa</h2>
                <hr>
                <p class="card-text">Import data siswa dalam format Excel untuk memperbarui data siswa dalam sistem. Pastikan file yang di-upload mengikuti template yang disediakan.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px; box-shadow: rgba(0, 0, 0, 0.03) 0px 4px 8px 0px;">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>


                    <form action="<?php echo site_url('import/upload'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                               value="<?= $this->security->get_csrf_hash(); ?>" />
                        <div class="form-group">
                            <label for="file_excel">File Excel</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file_excel" name="file_excel" required>
                                <label class="custom-file-label" for="file_excel">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Format file harus .xls atau .xlsx (Max 2MB)</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Import Data
                        </button>

                        <a href="<?php echo site_url('import/template'); ?>" class="btn btn-success">
                            <i class="fas fa-file-download"></i> Download Template
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4>Petunjuk Import:</h4>
            <ol>
                <li>Download template dengan klik tombol <strong>Download Template</strong></li>
                <li>Isi data siswa sesuai format template</li>
                <li>Jangan mengubah nama kolom/header</li>
                <li>Pastikan data NIS unik dan tidak duplikat</li>
                <li>Upload file melalui form di atas</li>
            </ol>

            <div class="alert alert-warning">
                <strong>Perhatian:</strong> Data dengan NIS yang sudah ada akan dilewati (tidak diimport).
            </div>
        </div>
    </section>
</div>

<script>
// Untuk menampilkan nama file di input
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("file_excel").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>

<style>
    .main-content {
        margin-top: 20px;
    }
</style>
