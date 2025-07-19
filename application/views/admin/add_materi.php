
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="">
                        <div class="card" style="width:100%;">
                            <div class="card-body">
                                <h2 class="card-title" style="color: black;">Tambah Data Materi</h2>
                                <hr>
                                <p class="card-text"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction.
                                </p>
                                <a href="#detail" class="btn btn-success">Saya paham dan
                                    ingin melanjutkan ⭢</a>
                            </div>
                        </div>
                        <div class="card card-success">
                            <div class="col-md-12 text-center">
                                <p class="registration-title font-weight-bold display-4 mt-4" style="color:black; font-size: 50px;">
                                    Tambah Materi</p>
                                <p style="line-height:-30px;margin-top:-20px;">Silahkan isi data data yang diperlukan
                                    dibawah </p>
                                <hr>
                            </div>
                            <div id="detail" class="card-body">
                                <form method="POST" enctype="multipart/form-data" action="<?= base_url('admin/add_materi') ?>">
                                   <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                     value="<?= $this->security->get_csrf_hash(); ?>" />
                                         <div class="col-md-12 bg-white" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                                            <input type="hidden" name="id">
                                            <input type="hidden" name="id_mapel" id="id_mapel">
                                            <div class="form-row">
                                               <div class="form-group col-md-12">
    <label for="guru">Pilih Guru</label>
    <select name="id_guru" id="guru_select" class="form-control selectric" required>
        <option value="">-- Pilih Guru --</option>
        <?php foreach ($guru as $g): ?>
            <option value="<?= $g->nip ?>"><?= $g->nama_guru ?> (<?= $g->nip ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="hidden" name="id_mapel" id="id_mapel"> 
    
    <div class="form-group col-md-12">
        <label for="mapel">Pilih Mata Pelajaran</label>
    <select name="id_mapel" id="mapel_select" class="form-control selectric" required>
        <option value="">-- Pilih mapel yang diajarkan guru --</option>
    </select>
</div>

                                                    <!-- Benar: -->
                                            <div class="form-group col-md-12">
                                                <label for="">Upload Video Materi</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input required type="file" name="video" required class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Upload
                                                            Video
                                                            Materi Disini</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                        <label>Upload File Materi (PDF, Word, JPG)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="modul" class="custom-file-input" required>
                                                <label class="custom-file-label">Pilih file</label>
                                            </div>
                                        </div>
                                    </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleFormControlTextarea1">Deskripsi Materi</label>
                                                <textarea class="form-control" required name="deskripsi" id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleFormControlTextarea1">Link Google Form</label>
                                                <textarea class="form-control" required name="linkform" id="exampleLinkForm"> </textarea>
                                                </div>
                                            <div class="form-group col-md-12">
                                                <label for="inputState">Kelas</label>
                                                <select name="id_kelas" class="form-control selectric">
                                                <?php foreach ($kelas as $k): ?>
                                                    <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
                                                <?php endforeach; ?>
                                                </select>

                                            </div>
                                            <button type="submit" class="btn btn-block btn-success">Tambah
                                                materi ⭢</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
                    </div>
                </section>
            </div>
        </div>
        <!-- End Main Content -->

        <script>
            function fillGuruData() {
                const select = document.getElementById('guru_select');
                const selectedOption = select.options[select.selectedIndex];

                const namaGuru = selectedOption.getAttribute('data-nama');
                const mapel = selectedOption.getAttribute('data-mapel');
                const idMapel = selectedOption.getAttribute('data-id_mapel');

                document.getElementById('nama_guru').value = namaGuru;
                document.getElementById('nama_mapel').value = mapel;
                document.getElementById('id_mapel').value = idMapel;
            }
        </script>

        <script>
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
        <script>
$(document).ready(function () {
    $('#guru_select').change(function () {
        const nipGuru = $(this).val();
        if (nipGuru) {
            $.ajax({
                url: '<?= base_url("admin/get_mapel_by_guru/") ?>' + nipGuru,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#mapel_select').html('<option value="">-- Pilih mapel --</option>');
                    $.each(data, function (i, item) {
                        $('#mapel_select').append('<option value="' + item.id + '">' + item.nama_mapel + '</option>');
                    });
                },
                error: function () {
                    alert('Gagal mengambil data mapel');
                }
            });
        } else {
            $('#mapel_select').html('<option value="">-- Pilih mapel --</option>');
        }
    });
});
</script>
