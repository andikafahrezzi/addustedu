
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #495057;
            margin-top: 20px;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-right:150px; 
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        
        .card-title {
            font-weight: 700;
            color: #344767 !important;
            margin-bottom: 20px;
        }
        
        .btn-success {
            background-color: #2dce89;
            border-color: #2dce89;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            background-color: #26af74;
            border-color: #26af74;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 206, 137, 0.3);
        }
        
        hr {
            border-color: #e9ecef;
            margin: 20px 0;
        }
        
        #detail {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            padding: 30px !important;
            margin-top: 30px;
        }
        
        table {
            margin-top: 20px;
            margin-bottom: 30px;
        }
        
        table tr {
            transition: background-color 0.2s ease;
        }
        
        table tr:hover {
            background-color: #f8f9fa;
        }
        
        table td {
            padding: 15px 10px;
            vertical-align: middle;
        }
        
        table td:first-child {
            font-weight: 600;
            color: #344767;
            width: 40%;
            text-align: right;
        }
        
        table td:last-child {
            color: #495057;
            text-align: left;
        }
        
        .badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 6px;
        }
        
        .header-icon {
            margin-right: 10px;
            color: #2dce89;
        }
        
        .animated-icon {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>

<div class="main-content">
    <section class="section">
        <div class="">
            <div class="card" style="width:100%; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-radius: 5px; border: none;">
                <div class="card-body">
                    <h2 class="card-title" style="color: black; font-weight: 600;">Detail Ujian | <?= $detail->nama_ujian ?> </h2>
                    <hr style="border-color: #eaeaea;">
                    <p class="card-text" style="color: #555; line-height: 1.6;"> After I ran into Helen at a restaurant, I realized she was just office pretty drop-dead date put in in a deck for our standup today. Who's responsible for the ask for this request? who's responsible for the ask for this request? but moving the goalposts gain traction.
                    </p>
                    <a href="#detail" class="btn btn-success" style="border-radius: 4px; font-weight: 500; padding: 8px 16px; box-shadow: 0 2px 5px rgba(45,206,137,0.2);">Saya paham dan
                        ingin melanjutkan ⭢</a>
                </div>
            </div>
            <br>
            <div class="col-md-12 bg-white p-3" id="detail" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.05) 0px 4px 12px 0px;">
                <h1 class="font-weight-bold card-title text-center" style="color: black; margin-top: 15px; font-size: 28px;">Detail Ujian </h1>
                <p class="text-center" style="line-height: 5px; color: #6c757d; margin-bottom: 20px;">Berikut data detail yang terdapat di
                    database, meliputi Nama, Email,
                    Photo, Akun aktif
                    dan Date Created.</p>
                <hr style="border-color: #eaeaea; margin-bottom: 20px;">
                <table style="width: 100%" class="container text-center">
                    <tbody>
                        <tr style="border-bottom: 0.5px solid #dee2e6;">
                            <td style="padding: 12px 8px; text-align: right;"><span class="font-weight-bold" style="color: #333; font-weight: 600;">Nama Ujian :</span></td>
                            <td style="padding: 12px 8px; text-align: left;"> <?= $detail->nama_ujian ?></td>
                        </tr>
                        <tr style="border-bottom: 0.5px solid #dee2e6;">
                            <td style="padding: 12px 8px; text-align: right;"><span class="font-weight-bold" style="color: #333; font-weight: 600;">Nip Guru :</span></td>
                            <td style="padding: 12px 8px; text-align: left;"> <?= $detail->nip_guru ?></td>
                        </tr>
                        <tr style="border-bottom: 0.5px solid #dee2e6;">
                            <td style="padding: 12px 8px; text-align: right;"><span class="font-weight-bold" style="color: #333; font-weight: 600;">Nama Guru : </span></td>
                            <td style="padding: 12px 8px; text-align: left;"> <?= $detail->nama_guru ?></td>
                        </tr>
                        <tr style="border-bottom: 0.5px solid #dee2e6;">
                            <td style="padding: 12px 8px; text-align: right;"><span class="font-weight-bold" style="color: #333; font-weight: 600;">Status Ujian :</span></td>
                            <td style="padding: 12px 8px; text-align: left;">
                                <span style="padding: 3px 8px; border-radius: 3px; font-size: 12px; background-color: <?= $detail->status == 'aktif' ? '#28a745' : '#dc3545' ?>; color: white;">
                                    <?= $detail->status ?>
                                </span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 0.5px solid #dee2e6;">
                            <td style="padding: 12px 8px; text-align: right;"><span class="font-weight-bold" style="color: #333; font-weight: 600;">Dimulai pada :</span></td>
                            <td style="padding: 12px 8px; text-align: left;"><?= $detail->tanggal_mulai ?></td>
                        </tr>
                        <tr style="border-bottom: 0.5px solid #dee2e6;">
                            <td style="padding: 12px 8px; text-align: right;"><span class="font-weight-bold" style="color: #333; font-weight: 600;">Berakhir pada :</span></td>
                            <td style="padding: 12px 8px; text-align: left;"><?= $detail->tanggal_selesai ?></td>
                        </tr>
                        <tr style="border-bottom: 0.5px solid #dee2e6;">
                            <td style="padding: 12px 8px; text-align: right;"><span class="font-weight-bold" style="color: #333; font-weight: 600;">Durasi Ujian :</span></td>
                            <td style="padding: 12px 8px; text-align: left;"><?= $detail->durasi ?> menit</td>
                        </tr>
                    </tbody>
                </table>
                <p style="font-weight:500px!important;font-size:18px;text-align:justify;" class="text-justify">
                </p>
                <a href="<?= base_url('admin/data_ujian') ?>" class="btn btn-success btn-block" style="border-radius: 4px; margin-top: 20px; font-weight: 500; padding: 10px; box-shadow: 0 2px 5px rgba(45,206,137,0.2);">Kembali</a>
            </div>
        </div>
    </section>
</div>
</div>
</div>
<!-- End Main Content -->


<script>
    $(document).ready(function() {
        $('#example').DataTable();
        
        // Smooth scroll untuk tombol "Saya paham"
        $('a[href="#detail"]').on('click', function(e) {
            e.preventDefault();
            
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top - 70
            }, 800, 'swing');
        });
        
        // Hover effect untuk baris tabel
        $('table tr').hover(
            function() {
                $(this).css('background-color', '#f8f9fa');
            },
            function() {
                $(this).css('background-color', '');
            }
        );
    });
</script>
