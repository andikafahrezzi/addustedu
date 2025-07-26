
                    <!-- end:: Subheader -->

                    <!-- begin:: Content -->

                    <!-- begin:: Content -->
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                        <div class="row">
                            <div class="col-md-12 bg-white p-4 container"
                                style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                                <form method="post" enctype="multipart/form-data"
                                    action="<?=base_url('guru/add_materi')?>">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                        value="<?= $this->security->get_csrf_hash(); ?>" />
                                    <input type="hidden" name="id">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">NIP</label>
                                            <input required type="text" readonly name="nama_guru" value="<?= $user['nip'] ?>" class="form-control" id="inputEmail4">                                                                           
                                            <label for="inputEmail4">Nama Guru</label>
                                            <input required type="text" readonly name="nama_guru" value="<?= $user['nama_guru'] ?>" class="form-control" id="inputEmail4">      
                                            <input type="hidden" name="id_mapel" value="<?= $user['id_mapel'] ?>">                                                                     
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
    <label>Pilih Mata Pelajaran</label>
    <div class="d-flex flex-wrap">
        <?php foreach ($user['mapel_diajar'] as $mapel): ?>
            <div class="form-check mr-3">
                <input class="form-check-input" type="checkbox" name="id_mapel[]" value="<?= $mapel['id'] ?>" id="mapel<?= $mapel['id'] ?>">
                <label class="form-check-label" for="mapel<?= $mapel['id'] ?>">
                    <?= $mapel['nama_mapel'] ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
</div>

                                    </div>
                                        <div class="form-group">
                                            <label for="pertemuan">Pertemuan Ke-</label>
                                            <input type="number" name="pertemuan" id="pertemuan" class="form-control" min="1" required>
                                        </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input required type="file" name="video" class="custom-file-input"
                                                    id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Upload Video
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
                                        <textarea class="form-control" required name="deskripsi"
                                            id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Link Google Form</label>
                                        <textarea class="form-control" required name="linkform" id="exampleLinkForm"> </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputState">Kelas</label>
                                        <select required id="inputState" name="id_kelas" class="form-control">
                                            <?php foreach ($kelas as $k): ?>
                                                    <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Tambah materi</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <!--End::Section-->
                <br>
                <!--end:: Widgets/Order Statistics-->


                <!-- begin:: Footer -->
                <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop">
                    <div class="kt-footer__copyright">
                        2025&nbsp;&copy;&nbsp;<a href="https://Andikafahrezi.github.io/" target="_blank"
                            class="kt-link">Andika Fahrezi</a>
                    </div>
                    <div class="kt-footer__menu">
                        Made with &nbsp; <span class="" style="color: red"> &#10084;</span> &nbsp; by Dika
                    </div>
                </div>

                <!-- end:: Footer -->
            </div>
        </div>
    </div>

    <!-- end:: Page -->



    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <!-- end::Scrolltop -->

    <!-- end::Demo Panel -->

    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#4dbf1c",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
    </script>

    <!-- end::Global Config -->

    <!--begin:: Global Mandatory Vendors -->
    <script src="<?=base_url('assets')?>/assets/vendors/general/jquery/dist/jquery.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/popper.js/dist/umd/popper.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap/dist/js/bootstrap.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/js-cookie/src/js.cookie.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/moment/min/moment.min.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/sticky-js/dist/sticky.min.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/wnumb/wNumb.js" type="text/javascript">
    </script>

    <!--end:: Global Mandatory Vendors -->

    <!--begin:: Global Optional Vendors -->
    <script src="<?=base_url('assets')?>/assets/vendors/general/jquery-form/dist/jquery.form.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/block-ui/jquery.blockUI.js" type="text/javascript">
    </script>
    <script
        src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/bootstrap-datepicker/init.js"
        type="text/javascript">
    </script>
    <script
        src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
        type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/bootstrap-timepicker/init.js"
        type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js"
        type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js"
        type="text/javascript">
    </script>
    <script
        src="<?=base_url('assets')?>/assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js"
        type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js"
        type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/bootstrap-switch/init.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/select2/dist/js/select2.full.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/typeahead.js/dist/typeahead.bundle.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/handlebars/dist/handlebars.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js"
        type="text/javascript"></script>
    <script
        src="<?=base_url('assets')?>/assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/nouislider/distribute/nouislider.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/owl.carousel/dist/owl.carousel.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/autosize/dist/autosize.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/clipboard/dist/clipboard.min.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/dropzone/dist/dropzone.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/summernote/dist/summernote.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/markdown/lib/markdown.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/bootstrap-markdown/init.js"
        type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-notify/bootstrap-notify.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/bootstrap-notify/init.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/jquery-validation/dist/jquery.validate.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/jquery-validation/dist/additional-methods.js"
        type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/jquery-validation/init.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/toastr/build/toastr.min.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/raphael/raphael.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/morris.js/morris.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/chart.js/dist/Chart.bundle.js" type="text/javascript">
    </script>
    <script
        src="<?=base_url('assets')?>/assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/waypoints/lib/jquery.waypoints.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/counterup/jquery.counterup.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/es6-promise-polyfill/promise.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/sweetalert2/init.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/jquery.repeater/src/lib.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/jquery.repeater/src/jquery.input.js"
        type="text/javascript"></script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/jquery.repeater/src/repeater.js" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/general/dompurify/dist/purify.js" type="text/javascript">
    </script>

    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="<?=base_url('assets')?>/assets/demo/demo7/base/scripts.bundle.js" type="text/javascript">
    </script>

    <!--end::Global Theme Bundle -->

    <!--begin::Page Vendors(used by this page) -->
    <script src="<?=base_url('assets')?>/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js"
        type="text/javascript"></script>
    <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript">
    </script>
    <script src="<?=base_url('assets')?>/assets/vendors/custom/gmaps/gmaps.js" type="text/javascript">
    </script>

    <!--end::Page Vendors -->

    <!--begin::Page Scripts(used by this page) -->
    <script src="<?=base_url('assets')?>/assets/app/custom/general/dashboard.js" type="text/javascript">
    </script>

    <!--end::Page Scripts -->

    <!--begin::Global App Bundle(used by all pages) -->
    <script src="<?=base_url('assets')?>/assets/app/bundle/app.bundle.js" type="text/javascript">
    </script>

    <!--end::Global App Bundle -->
</body>

<!-- end::Body -->

</html>