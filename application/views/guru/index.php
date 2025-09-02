<!--
@Project: addustedu
@Programmer: Syauqi Zaidan Khairan Khalaf
@Website: https://linktr.ee/syauqi
@Email : syaokay@gmail.com

@About-addustedu :
Web Edukasi Open Source yang dibuat oleh Syauqi Zaidan Khairan Khalaf.
addustedu adalah Web edukasi yang dilengkapi video, materi dan sistem ujian
yang tersedia secara gratis. addustedu dibuat ditujukan agar para siswa dan
guru dapat terus belajar dan mengajar dimana saja dan kapan saja.
-->


                <!-- end:: Header -->
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

                    <!-- begin:: Subheader -->
                    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                        <div class="kt-subheader__main">
                            <h1 class="kt-subheader__title font-weight-bold"
                                style="font-size: 33px !important; letter-spacing:-1px; line-height:3px;">
                                Dashboard </h1>
                        </div>
                        <div class="kt-subheader__toolbar">
                            <div class="kt-subheader__wrapper">
                                <a href="#" class="btn kt-subheader__btn-daterange">
                                    <span class="kt-subheader__btn-daterange-title"
                                        id="kt_dashboard_daterangepicker_title">Tanggal</span>&nbsp;
                                    <span class="kt-subheader__btn-daterange-date"
                                        id="kt_dashboard_daterangepicker_date"><?php echo date('d / M / y'); ?></span>

                                    <!--<i class="flaticon2-calendar-1"></i>-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        class="kt-svg-icon kt-svg-icon--sm">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z"
                                                id="check" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path
                                                d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                id="Combined-Shape" fill="#000000" />
                                        </g>
                                    </svg> </a>
                            </div>
                        </div>
                    </div>

                    <!-- end:: Subheader -->

                    <!-- begin:: Content -->

                    <!-- begin:: Content -->
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

                        <!--Begin::Dashboard 7-->

                        <!--Begin::Section-->

                        <div class="row">
                            <div class="col-xl-12">

                                <!--begin:: Widgets/Blog-->
                                <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <div class="kt-widget19__pic kt-portlet-fit--top kt-portlet-fit--sides">
                                            <img src="<?=base_url('assets/')?>img/user.png" class=" img-fluid" alt=""
                                                srcset="">
                                            <h1 class="welcome-heading">
                                                Selamat Datang, <?php
                                                    $data['user'] = $this->db->get_where('guru', ['nip' =>
                                                        $this->session->userdata('nip')])->row_array();
                                                    echo $data['user']['nama_guru'];
                                                ?> !
                                            </h1>
                                            <div class="kt-widget19__shadow"></div>
                                            <div class="kt-widget19__labels">
                                                <a href="#" class="btn btn-label-light-o2 btn-bold btn-sm ">Cipta Tunas Karya</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget19__wrapper">
                                            <div class="kt-widget19__content">
                                                <div class="kt-widget19__userpic">
                                                    <img src="<?=base_url('assets/')?>assets/media/users/default.jpg"
                                                        alt="">
                                                </div>
                                                <div class="kt-widget19__info">
                                                    <a href="#" class="kt-widget19__username font-weight-bold">
                                                        Administrator
                                                    </a>
                                                    <span class="kt-widget19__time">
                                                        Administrator
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="kt-widget19__text">
                                                Selamat datang di halaman guru ctkarya, anda dapat menambah materi .
                                                Dalam materi anda dapat memasukan video, dan deskripsi nya. Seemoga anda
                                                dapat menikmati ctkarya!, kontak Administrator jika terjadi masalah
                                                apapun yang terkait upload materi. Terima kasih telah menggunakan
                                                ctkarya!
                                                <br>
                                                Selamat Bekerja :)
                                            </div>
                                        </div>
                                        <div class="kt-widget19__action">
                                            <a href=<?=base_url('guru/add_materi')?> class="btn btn-sm btn-label-brand btn-bold">Tambah Materi</a>
                                        </div>
                                    </div>
                                </div>

                                <!--end:: Widgets/Blog-->
                            </div>
                        </div>

                        <!--End::Section-->

                        <!--end:: Widgets/Order Statistics-->


