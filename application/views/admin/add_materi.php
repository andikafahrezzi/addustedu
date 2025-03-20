
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
                                    <div class="col-md-12 bg-white" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                                        <form method="post" enctype="multipart/form-data" action="<?= base_url('guru/add_materi') ?>">
                                            <input type="hidden" name="id">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="inputEmail4">Nama Guru</label>
                                                    <input autocomplete="off" required type="text" list="nama_guru" onkeyup="autofill()" id="namaguru" name="nama_guru" class="form-control">
                                                    <small>List guru sudah tersedia di autocomplete, kalian hanya
                                                        tinggal klik input area nya atau dengan cara menulis namanya dan
                                                        klik guru yang akan dipilih.</small>
                                                    <datalist id=nama_guru>
                                                        <?php
                                                        include "koneksi.php";
                                                        $qry = mysqli_query($koneksi, "SELECT nama_guru From guru");
                                                        while ($t = mysqli_fetch_array($qry)) {
                                                            echo "<option value='$t[nama_guru]'>";
                                                        }
                                                        ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nama Mata Pelajaran</label>
                                                <input type="text" class="form-control" name="nama_mapel" id="nama_mapel" required placeholder="Pilih nama guru yang valid agar nama mapel muncul" readonly>
                                                <small>Jika nama mapel sudah berganti artinya nama guru yang kamu
                                                    masukan di input area adalah valid! jika tidak muncul nama mapel
                                                    anda harus klik input area nama guru dan pilih guru yang tersedia
                                                    disana.</small>
                                            </div>
                                            <div class="form-group">
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
                                            <div class="form-group">
                                        <label>Upload File Materi (PDF, Word, JPG)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="modul" class="custom-file-input" required>
                                                <label class="custom-file-label">Pilih file</label>
                                            </div>
                                        </div>
                                    </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Deskripsi Materi</label>
                                                <textarea class="form-control" required name="deskripsi" id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Link Google Form</label>
                                                <textarea class="form-control" required name="linkform" id="exampleLinkForm"> </textarea>
                                                </div>
                                            <div class="form-group">
                                                <label for="inputState">Kelas</label>
                                                <select required id="inputState" name="kelas" class="form-control">
                                                    <option selected>Pilih disini</option>
                                                    <option value="X">X ( Kelas Sepuluh )</option>
                                                    <option value="XI">XI ( Kelas Sebelas )</option>
                                                    <option value="XII">XII ( Kelas Dua Belas )</option>
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

        <!-- Start Footer -->
        <footer class="main-footer">
            <div class="text-center">
                Copyright &copy; 2020 <div class="bullet"></div><a href="https://github.com/syauqi">Syauqi Zaidan Khairan Khalaf</a>
            </div>
        </footer>
        <!-- End Footer -->

        <!-- General JS Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>
            function autofill() {
                var nama_guru = $("#namaguru").val();
                $.ajax({
                    url: '../autofill.php',
                    data: "nama_guru=" + nama_guru,
                }).done(function(data) {
                    var json = data,
                        obj = JSON.parse(json);
                    $('#nama_mapel').val(obj.nama_mapel);
                });
            }
        </script>
        <script>
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="<?= base_url('assets/') ?>stisla-assets/js/stisla.js"></script>
        <!-- JS Libraies -->
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
        <!-- Template JS File -->
        <script src="<?= base_url('assets/') ?>stisla-assets/js/scripts.js"></script>
        <script src="<?= base_url('assets/') ?>stisla-assets/js/custom.js"></script>
        <!-- Page Specific JS File -->
</body>

</html>