<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ujian <?= htmlspecialchars($ujian->nama_ujian) ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f9f9;
            margin-top: 200px;
        }

        .ujian-title {
            text-align: center;
            color: #34495e;
            margin-bottom: 10px;
        }

        .timer {
            text-align: center;
            color: #e74c3c;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .soal-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .soal-title {
            font-size: 18px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .pilihan-jawaban label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pilihan-jawaban label:hover {
            background-color: #f0f0f0;
        }

        .soal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-warning {
            background-color: #f1c40f;
            color: white;
        }

        .btn-success {
            background-color: #2ecc71;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        #navigasi {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .navigasi-title {
            margin-bottom: 10px;
            color: #34495e;
        }

        .nav-btn {
            background-color: #ecf0f1;
            color: #2c3e50;
            border: 1px solid #bdc3c7;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .nav-btn.answered {
            background-color: #2ecc71;
            color: white;
            border-color: #27ae60;
        }

        .nav-btn.ragu {
            background-color: #f39c12;
            color: white;
            border-color: #e67e22;
        }

        .nav-btn.current {
            background-color: #3498db;
            color: white;
            border-color: #2980b9;
        }

        .nav-btn:hover {
            background-color: #3498db;
            color: white;
        }

        .submit-area {
            text-align: center;
            margin-top: 30px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }
    </style>
    <meta name="csrf_token" content="<?php echo $this->security->get_csrf_hash(); ?>">
</head>
<body>
<pre><?php print_r($soal); ?></pre>


<h2 class="ujian-title">Ujian: <?= htmlspecialchars($ujian->nama_ujian) ?></h2>
<h3 id="timer" class="timer"></h3>

<div id="soal-container">
    <?php if (!empty($soal)): ?>
        <?php foreach ($soal as $index => $s): ?>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="soal-card" id="soal<?= $index ?>" style="display: <?= $index == 0 ? 'block' : 'none' ?>;">
        <p class="soal-title"><b>Soal <?= $index + 1 ?>:</b> <?= htmlspecialchars($s['pertanyaan']) ?></p>
        <div class="pilihan-jawaban">
            <label>
                <input type="radio" name="jawaban<?= $s['id'] ?>" value="A" 
                    <?= (isset($jawaban_siswa) && $jawaban_siswa->jawaban == 'A' ? 'checked' : '') ?>
                    onclick="saveAnswer(<?= $s['id'] ?>,'A','<?= $s['sumber'] ?>')"> 
                A. <?= htmlspecialchars($s['pilihan_a']) ?>
            </label>
            <label>
                <input type="radio" name="jawaban<?= $s['id'] ?>" value="B" 
                    <?= (isset($jawaban_siswa) && $jawaban_siswa->jawaban == 'B' ? 'checked' : '') ?>
                    onclick="saveAnswer(<?= $s['id'] ?>,'B','<?= $s['sumber'] ?>')"> 
                B. <?= htmlspecialchars($s['pilihan_b']) ?>
            </label>
            <label>
                <input type="radio" name="jawaban<?= $s['id'] ?>" value="C" 
                    <?= (isset($jawaban_siswa) && $jawaban_siswa->jawaban == 'C' ? 'checked' : '') ?>
                    onclick="saveAnswer(<?= $s['id'] ?>,'C','<?= $s['sumber'] ?>')"> 
                C. <?= htmlspecialchars($s['pilihan_c']) ?>
            </label>
            <label>
                <input type="radio" name="jawaban<?= $s['id'] ?>" value="D" 
                    <?= (isset($jawaban_siswa) && $jawaban_siswa->jawaban == 'D' ? 'checked' : '' )?>
                    onclick="saveAnswer(<?= $s['id'] ?>,'D','<?= $s['sumber'] ?>')"> 
                D. <?= htmlspecialchars($s['pilihan_d']) ?>
            </label>
        </div>
        <div class="soal-actions">
            <button class="btn btn-warning" onclick="raguRagu(<?= $s['id'] ?>)">
                <?= (isset($jawaban_siswa) && $jawaban_siswa->ragu_ragu ? 'Batal Ragu' : 'Tandai Ragu') ?>
            </button>
            <button class="btn btn-secondary" onclick="previousSoal()" <?= $index == 0 ? 'disabled' : '' ?>>Sebelumnya</button>
            <button class="btn btn-primary" onclick="nextSoal()" <?= $index == count($soal) - 1 ? 'disabled' : '' ?>>Berikutnya</button>
        </div>
    </div>
<?php endforeach; ?>
    <?php else: ?>
        <div class="soal-card">
            <p class="soal-title">Tidak ada soal tersedia untuk ujian ini.</p>
        </div>
    <?php endif; ?>
</div>

<div id="navigasi">
    <h4 class="navigasi-title">Navigasi Soal</h4>
    <?php if (!empty($soal)): ?>
        <?php foreach ($soal as $index => $s): ?>
            <?php 
            $jawaban = $this->db->get_where('tbl_jawaban_siswa', [
                'id_soal' => $s['id'], 
                'id_ujian' => $ujian->id_ujian,
                'nis' => $nis
            ])->row();
            
            $class = '';
            if ($jawaban) {
                $class = $jawaban->ragu_ragu ? 'ragu' : ($jawaban->jawaban ? 'answered' : '');
            }
            ?>
            <button class="nav-btn <?= $class ?>" id="nav<?= $index ?>" onclick="gotoSoal(<?= $index ?>)">
                <?= $index + 1 ?>
            </button>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada soal untuk dinavigasi</p>
    <?php endif; ?>
</div>

<div class="submit-area">
    <button class="btn btn-success" onclick="submitUjian()">Submit Ujian</button>
</div>

<script>
    let totalSoal = <?= !empty($soal) ? count($soal) : 0 ?>;
    let current = 0;
    let sisa_waktu = <?= $sisa_waktu ?? 0 ?>;
    let ujian_id = <?= $ujian->id_ujian ?? 0 ?>;

    // Fungsi untuk menandai tombol navigasi saat ini
    function updateNavigation() {
        $('.nav-btn').removeClass('current');
        $('#nav' + current).addClass('current');
    }

    function gotoSoal(index) {
        if (index < 0 || index >= totalSoal) return;
        
        $('.soal-card').hide();
        $('#soal' + index).show();
        current = index;
        
        // Update tombol navigasi
        updateNavigation();
        
        // Update tombol previous/next
        $('.soal-actions button').prop('disabled', false);
        if (index === 0) {
            $('.soal-actions button:contains("Sebelumnya")').prop('disabled', true);
        }
        if (index === totalSoal - 1) {
            $('.soal-actions button:contains("Berikutnya")').prop('disabled', true);
        }
    }

    function nextSoal() {
        if (current < totalSoal - 1) {
            current++;
            gotoSoal(current);
        }
    }

    function previousSoal() {
        if (current > 0) {
            current--;
            gotoSoal(current);
        }
    }

    function saveAnswer(id_soal, jawaban, sumber) {
    // Validasi parameter
    if (!id_soal || !jawaban || !sumber) {
        console.error('Parameter tidak lengkap:', {id_soal, jawaban, sumber});
        alert('Data tidak lengkap untuk menyimpan jawaban');
        return;
    }

    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    
    $.ajax({
        url: '<?= site_url("ujian/simpan_jawaban_ajax") ?>',
        method: 'POST',
        dataType: 'json',
        data: {
            id_soal: id_soal,
            jawaban: jawaban,
            ragu: 0,
            sumber: sumber,
            [csrfName]: csrfHash
        },
        success: function(response) {
            if(response.status === 'success') {
                $('#nav' + current).addClass('answered').removeClass('ragu');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr) {
            var errorMsg = 'Gagal menyimpan jawaban. ';
            if(xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg += xhr.responseJSON.message;
            } else {
                errorMsg += 'Status: ' + xhr.status;
            }
            alert(errorMsg);
        }
    });
}
// Panggil dengan menyertakan sumber soal
onclick="saveAnswer(<?= $s['id'] ?>,'A','<?= $s['sumber'] ?>')"

function raguRagu(id_soal) {
    var jawaban = $('input[name="jawaban' + id_soal + '"]:checked').val();
    if (jawaban) {
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        $.ajax({
            url: '<?= site_url("ujian/simpan_jawaban_ajax") ?>',
            method: 'POST',
            data: {
                id_soal: id_soal,
                jawaban: jawaban,
                ragu: 1,
                [csrfName]: csrfHash
            },
            success: function(response) {
                if(response.status === 'success') {
                    var btn = $('#nav' + current);
                    if (btn.hasClass('ragu')) {
                        btn.removeClass('ragu').addClass('answered');
                        $('.btn-warning').text('Tandai Ragu');
                    } else {
                        btn.removeClass('answered').addClass('ragu');
                        $('.btn-warning').text('Batal Ragu');
                    }
                }
            }
        });
    } else {
        alert('Pilih jawaban terlebih dahulu sebelum menandai ragu!');
    }
}

function raguRagu(id_soal) {
    let jawaban = $('input[name=jawaban' + id_soal + ']:checked').val();
    if (jawaban) {
        // Tambahkan CSRF token
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        
        $.ajax({
            url: '<?= site_url("ujian/simpan_jawaban_ajax") ?>',
            method: 'POST',
            data: {
                id_soal: id_soal,
                jawaban: jawaban,
                ragu: 1,
                [csrfName]: csrfHash // Tambahkan CSRF token
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let btn = $('#nav' + current);
                    let raguBtn = $('.soal-actions button:contains("Tandai Ragu"), .soal-actions button:contains("Batal Ragu")').first();
                    
                    if (btn.hasClass('ragu')) {
                        btn.removeClass('ragu').addClass('answered');
                        raguBtn.text('Tandai Ragu');
                    } else {
                        btn.removeClass('answered').addClass('ragu');
                        raguBtn.text('Batal Ragu');
                    }
                } else {
                    alert('Gagal menyimpan: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Gagal menyimpan jawaban. Status: ' + status + '\nError: ' + error);
            }
        });
    } else {
        alert('Pilih jawaban terlebih dahulu sebelum menandai ragu!');
    }
}

    function submitUjian(auto = false) {
        if (auto || confirm('Apakah Anda yakin ingin mengumpulkan ujian ini?\nPastikan semua jawaban sudah diperiksa.')) {
            window.location.href = '<?= site_url("ujian/submit_ujian") ?>';
        }
    }

    // Inisialisasi pertama kali
    $(document).ready(function() {
        updateNavigation();
        
        // Timer
        if (sisa_waktu > 0) {
            let timer = setInterval(function() {
                let menit = Math.floor(sisa_waktu / 60);
                let detik = sisa_waktu % 60;
                
                // Format waktu dengan leading zero
                let menitStr = menit < 10 ? '0' + menit : menit;
                let detikStr = detik < 10 ? '0' + detik : detik;
                
                $('#timer').text('Sisa Waktu: ' + menitStr + ':' + detikStr);
                
                if (sisa_waktu <= 0) {
                    clearInterval(timer);
                    submitUjian(true);
                } else {
                    sisa_waktu--;
                }
                
                // Peringatan waktu hampir habis
                if (sisa_waktu === 300) { // 5 menit
                    alert('Waktu tersisa 5 menit! Segera periksa jawaban Anda.');
                }
            }, 1000);
        }
    });
</script>

</body>
</html>