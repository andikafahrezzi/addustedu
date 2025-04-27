<!DOCTYPE html>
<html>
<head>
    <title>Ujian <?= $ujian->nama_ujian ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h2 class="ujian-title">Ujian: <?= $ujian->nama_ujian ?></h2>
<h3 id="timer" class="timer"></h3>

<div id="soal-container">
    <?php foreach ($soal as $index => $s): ?>
        <div class="soal-card" id="soal<?= $index ?>" style="display: <?= $index==0 ? 'block' : 'none' ?>;">
            <p class="soal-title"><b>Soal <?= $index+1 ?>:</b> <?= $s->pertanyaan ?></p>
            <div class="pilihan-jawaban">
                <label><input type="radio" name="jawaban<?= $s->id_soal ?>" value="A" onclick="saveAnswer(<?= $s->id_soal ?>,'a')"> A. <?= $s->pilihan_a ?></label><br>
                <label><input type="radio" name="jawaban<?= $s->id_soal ?>" value="B" onclick="saveAnswer(<?= $s->id_soal ?>,'b')"> B. <?= $s->pilihan_b ?></label><br>
                <label><input type="radio" name="jawaban<?= $s->id_soal ?>" value="C" onclick="saveAnswer(<?= $s->id_soal ?>,'c')"> C. <?= $s->pilihan_c ?></label><br>
                <label><input type="radio" name="jawaban<?= $s->id_soal ?>" value="D" onclick="saveAnswer(<?= $s->id_soal ?>,'d')"> D. <?= $s->pilihan_d ?></label><br>
            </div>

            <div class="soal-actions">
                <button class="btn btn-warning" onclick="raguRagu(<?= $s->id_soal ?>)">Tandai Ragu</button>
                <button class="btn btn-secondary" onclick="previousSoal()">Previous</button>
                <button class="btn btn-primary" onclick="nextSoal()">Next</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="navigasi">
    <h4 class="navigasi-title">Navigasi Soal</h4>
    <?php foreach ($soal as $index => $s): 
        // Tambahan: Cek jawaban siswa
        $jawaban = $this->db->get_where('tbl_jawaban_siswa', ['id_soal' => $s->id_soal, 'nis' => $nis])->row();
        $class = '';
        if($jawaban){
            if($jawaban->ragu_ragu == 1){
                $class = 'ragu';
            } else if($jawaban->jawaban){
                $class = 'answered';
            }
        }
    ?>
        <button class="nav-btn <?= $class ?>" id="nav<?= $index ?>" onclick="gotoSoal(<?= $index ?>)"><?= $index+1 ?></button>
        
    <?php endforeach; ?>
</div>

<!-- Submit Ujian -->
<div class="submit-area">
    <button class="btn btn-success" onclick="submitUjian()">Submit Ujian</button>
</div>

<!-- Form untuk submit jawaban -->
<form id="submitForm" action="<?= site_url('ujian/submit_ujian') ?>" method="POST">
    <input type="hidden" name="id_ujian" value="<?= $ujian->id_ujian ?>">
    <?php foreach ($soal as $index => $s): ?>
        <input type="hidden" name="jawaban<?= $s->id_soal ?>" id="jawaban<?= $s->id_soal ?>">  <!-- Jawaban Soal -->
        <input type="hidden" name="ragu_<?= $s->id_soal ?>" id="ragu_<?= $s->id_soal ?>">  <!-- Ragu -->
    <?php endforeach; ?>
</form>

<script>
// Timer Ujian pakai localStorage
var totalSoal = <?= count($soal) ?>;
var current = 0;
var waktuUjianKey = 'waktu_ujian_<?= $ujian->id_ujian ?>';
var menit, detik;

// Cek apakah ada waktu disimpan
if(localStorage.getItem(waktuUjianKey)){
    var sisa = parseInt(localStorage.getItem(waktuUjianKey));
    menit = Math.floor(sisa / 60);
    detik = sisa % 60;
} else {
    menit = <?= $ujian->durasi ?>;
    detik = 0;
}

var timer = setInterval(function(){
    if(detik == 0){
        if(menit == 0){
            clearInterval(timer);
            alert("Waktu habis! Jawaban akan dikirim otomatis!");
            submitUjian(true);
        } else {
            menit--;
            detik = 59;
        }
    } else {
        detik--;
    }
    localStorage.setItem(waktuUjianKey, menit*60 + detik);
    document.getElementById('timer').innerHTML = 'Sisa Waktu: ' + menit + ' menit ' + detik + ' detik';
}, 1000);

// Navigasi
function gotoSoal(index){
    $('.soal-card').hide();
    $('#soal'+index).show();
    current = index;
}

// Navigasi ke soal berikutnya
// Menyimpan jawaban ke input hidden
function saveAnswerToHidden(index){
    var jawaban = $('input[name=jawaban'+soal[index].id_soal+']:checked').val();
    var ragu_ragu = $('#ragu_ragu'+soal[index].id_soal).val(); // Status ragu

    // Menyimpan jawaban yang dipilih dan status ragu di input hidden
    $('#jawaban' + soal[index].id_soal).val(jawaban);
    $('#ragu_ragu' + soal[index].id_soal).val(ragu_ragu);
}


function nextSoal() {
    saveCurrentAnswer(); // Simpan jawaban sebelum pindah
    if (current < totalSoal - 1) {
        current++;
        gotoSoal(current);
    }
}

// Navigasi ke soal sebelumnya
function previousSoal() {
    saveCurrentAnswer(); // Simpan jawaban sebelum pindah
    if (current > 0) {
        current--;
        gotoSoal(current);
    }
}

// Fungsi untuk menyimpan jawaban soal saat ini
function saveCurrentAnswer() {
    var currentSoalId = <?= $soal[0]->id_soal ?> + current; // Asumsi ID soal berurutan
    var jawaban = $('input[name=jawaban' + currentSoalId + ']:checked').val();
    
    if (jawaban) {
        $('#jawaban' + currentSoalId).val(jawaban);
        $('#nav' + current).addClass('answered').removeClass('ragu');
    }
}

// Navigasi ke soal berdasarkan indeks
function gotoSoal(index){
    // Sembunyikan semua soal
    $('.soal-card').hide();

    // Menampilkan soal sesuai dengan index
    $('#soal' + index).show();
}


// Simpan Jawaban
// Simpan Jawaban
function saveAnswer(id_soal, jawaban) {
    $('#jawaban' + id_soal).val(jawaban);
    $('#ragu_' + id_soal).val(0); // Pastikan status ragu direset
    $('#nav' + current).addClass('answered').removeClass('ragu');
}

// Tandai Ragu
// Tandai Ragu
function raguRagu(id_soal) {
    var jawaban = $('input[name=jawaban' + id_soal + ']:checked').val();
    if (jawaban) {
        $('#jawaban' + id_soal).val(jawaban);
        $('#ragu_' + id_soal).val(1);
        $('#nav' + current).addClass('ragu').removeClass('answered');
    } else {
        alert('Pilih jawaban terlebih dahulu sebelum menandai ragu!');
    }
}


// Submit Ujian
function submitUjian(autoSubmit = false){
    if (autoSubmit) {
        // Jika otomatis submit (waktu habis)
        localStorage.removeItem('waktu_ujian_<?= $ujian->id_ujian ?>');
        $('#submitForm').submit();  // Memanggil form submit
    } else {
        if (confirm('Yakin semua jawaban sudah diisi dan ingin submit ujian ini?')) {
            // Submit ujian manual
            localStorage.removeItem('waktu_ujian_<?= $ujian->id_ujian ?>');
            $('#submitForm').submit();  // Memanggil form submit
        }
    }
}

// Anti Refresh / Anti Tutup
window.onbeforeunload = function() {
    return "Ujian masih berlangsung, yakin mau keluar? Semua jawaban bisa hilang!";
};
</script>


<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f9f9;
    margin: 0;
    padding: 20px;
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
}
.belum-dijawab {
    background-color: red;
    color: white;
    border: none;
    margin: 2px;
    padding: 10px;
    border-radius: 50%;
}
.sudah-dijawab {
    background-color: blue;
    color: white;
    border: none;
    margin: 2px;
    padding: 10px;
    border-radius: 50%;
}

.soal-actions {
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    margin-right: 10px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
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
}

.nav-btn.answered {
    background-color: #2ecc71;
    color: white;
}

.nav-btn.ragu {
    background-color: #f39c12;
    color: white;
}

.submit-area {
    text-align: center;
    margin-top: 30px;
}

/* Highlight on hover */
.nav-btn:hover {
    background-color: #3498db;
    color: white;
}
</style>

</body>
</html>
