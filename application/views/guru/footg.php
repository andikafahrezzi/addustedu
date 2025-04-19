                        <!-- begin:: Footer -->
                        <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop">
                            <div class="kt-footer__copyright">
                                2024&nbsp;&copy;&nbsp;<a href="https://github.com/Andikafahrezi" target="_blank"
                                    class="kt-link">Andika Fahrezi</a>
                            </div>
                            <div class="kt-footer__menu">
                                Made with &nbsp; <span class="" style="color: red"> &#10084;</span> &nbsp; by AndikaFahrezi
                            </div>
                        </div>

                        <!-- end:: Footer -->
                    </div>
                </div>
            </div>

            <!-- end:: Page -->

            <!-- end::Quick Panel -->

            <!-- begin::Scrolltop -->
            

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

            <?php if ($this->session->flashdata('success-reg')): ?>
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Materi Telah Ditambahkan!',
                text: 'Selamat data ditambah!',
                showConfirmButton: false,
                timer: 2500
            })
            </script>
            <?php endif;?>
            <?php if ($this->session->flashdata('user-delete')): ?>
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Siswa Telah Dihapus!',
                text: 'Selamat data telah Dihapus!',
                showConfirmButton: false,
                timer: 2500
            })
            </script>
            <?php endif;?>
            <?php if ($this->session->flashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $this->session->flashdata('error'); ?>',
            footer: 'Cek kembali data yang Anda inputkan.'
        });
    </script>
<?php endif; ?>
            <!-- end::Global Config -->

            <!--begin:: Global Mandatory Vendors -->
            <script src="<?=base_url('assets')?>/assets/vendors/general/jquery/dist/jquery.js" type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/popper.js/dist/umd/popper.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap/dist/js/bootstrap.min.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/js-cookie/src/js.cookie.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/moment/min/moment.min.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/sticky-js/dist/sticky.min.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/wnumb/wNumb.js" type="text/javascript">
            </script>

            <!--end:: Global Mandatory Vendors -->

            <!--begin:: Global Optional Vendors -->
            <script src="<?=base_url('assets')?>/assets/vendors/general/jquery-form/dist/jquery.form.min.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/block-ui/jquery.blockUI.js"
                type="text/javascript">
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
            <script
                src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/bootstrap-timepicker/init.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js"
                type="text/javascript">
            </script>
            <script
                src="<?=base_url('assets')?>/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"
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
            <script src="<?=base_url('assets')?>/assets/vendors/general/select2/dist/js/select2.full.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/typeahead.js/dist/typeahead.bundle.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/handlebars/dist/handlebars.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js"
                type="text/javascript"></script>
            <script
                src="<?=base_url('assets')?>/assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js"
                type="text/javascript"></script>
            <script
                src="<?=base_url('assets')?>/assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/nouislider/distribute/nouislider.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/owl.carousel/dist/owl.carousel.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/autosize/dist/autosize.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/clipboard/dist/clipboard.min.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/dropzone/dist/dropzone.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/summernote/dist/summernote.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/markdown/lib/markdown.js"
                type="text/javascript">
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
            <script src="<?=base_url('assets')?>/assets/vendors/general/toastr/build/toastr.min.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/raphael/raphael.js" type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/morris.js/morris.js" type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/chart.js/dist/Chart.bundle.js"
                type="text/javascript">
            </script>
            <script
                src="<?=base_url('assets')?>/assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/waypoints/lib/jquery.waypoints.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/counterup/jquery.counterup.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/es6-promise-polyfill/promise.min.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/custom/components/vendors/sweetalert2/init.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/jquery.repeater/src/lib.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/jquery.repeater/src/jquery.input.js"
                type="text/javascript"></script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/jquery.repeater/src/repeater.js"
                type="text/javascript">
            </script>
            <script src="<?=base_url('assets')?>/assets/vendors/general/dompurify/dist/purify.js"
                type="text/javascript">
            </script>

            <!--end:: Global Optional Vendors -->

            <!--begin::Global Theme Bundle(used by all pages) -->
            <script src="<?=base_url('assets')?>/assets/demo/demo7/base/scripts.bundle.js" type="text/javascript">
            </script>

            <!--end::Global Theme Bundle -->

            <!--begin::Page Vendors(used by this page) -->
            <script src="<?=base_url('assets')?>/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js"
                type="text/javascript"></script>
            <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM"
                type="text/javascript">
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