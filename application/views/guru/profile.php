<section class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-4 text-center">Ubah Profil</h4>

                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
        
                    <form method="post" action="<?= base_url('guru/update_profile'); ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                    value="<?= $this->security->get_csrf_hash(); ?>" />
                        <input type="hidden" name="nip" value="<?= $guru->nip; ?>">

                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama_guru" class="form-control" value="<?= $guru->nama_guru; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $guru->email; ?>" required>
                            <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <div class="form-group">
    <label for="password">Password Baru (kosongkan jika tidak diubah)</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" placeholder="********">
        
    </div>
</div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary bubbly-button">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
