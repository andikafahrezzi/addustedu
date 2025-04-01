

<!-- Sweetaler Flashdata -->
<?php if ($this->session->flashdata('success-add')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'succes!',
            text: 'Kamu berhasil Manambahkan komentar!',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>


<?php if ($this->session->flashdata('success-edit')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Berhasil Di Edit!',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>





<?php if ($this->session->flashdata('success-logout')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Kamu berhasil logout!',
            text: 'Selamat tinggal, Sampai jumpa lagi!',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>


<?php if ($this->session->flashdata('error-comment')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Gagal Mengirim Komentar!',
            showConfirmButton: false,
            timer: 2500
        });
    </script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('myvideo');
    const progressBar = document.getElementById('progress-bar');
    const timeDisplay = document.getElementById('time-display');
    
    video.addEventListener('timeupdate', function() {
        const progress = (video.currentTime / video.duration) * 100;
        progressBar.value = progress;
        
        const currentTime = formatTime(video.currentTime);
        const duration = formatTime(video.duration);
        timeDisplay.textContent = `${currentTime} / ${duration}`;
    });
    
    progressBar.addEventListener('input', function() {
        const seekTime = (progressBar.value / 100) * video.duration;
        video.currentTime = seekTime;
    });
    
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }
});
</script>

<!-- Discussion Forum Script -->
<script>
// Toggle Form Edit
function toggleEditForm(commentId) {
    const displayDiv = document.getElementById(`comment-display-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);
    
    if (editForm.style.display === 'none' || !editForm.style.display) {
        displayDiv.style.display = 'none';
        editForm.style.display = 'block';
    } else {
        displayDiv.style.display = 'block';
        editForm.style.display = 'none';
    }
}

// Toggle Reply Form
function toggleReplyForm(commentId) {
    const displayDiv = document.getElementById(`comment-display-${commentId}`);
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    
    if (replyForm.style.display === 'none' || !replyForm.style.display) {
        displayDiv.style.display = 'none';
        replyForm.style.display = 'block';
    } else {
        displayDiv.style.display = 'block';
        replyForm.style.display = 'none';
    }
}

// Konfirmasi Hapus
function confirmDelete(commentId) {
    if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
        fetch(`<?= base_url('forum/hapus_komentar/') ?>${commentId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Menandai sebagai AJAX request
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Hapus elemen komentar dari DOM
                const commentElement = document.getElementById(`comment-${commentId}`);
                if (commentElement) {
                    commentElement.remove();
                }
                // Tampilkan notifikasi
                Swal.fire({
                        title: 'Berhasil!',
                        text: 'Komentar telah dihapus',
                        icon: 'success',
                        timer: 2500,
                        showConfirmButton: false
                    });
            } else {
                Swal.fire({
                        title: 'Berhasil!',
                        text: 'Komentar telah dihapus',
                        icon: 'success',
                        timer: 2500,
                        showConfirmButton: false
                    });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                        title: 'Berhasil!',
                        text: 'Komentar telah dihapus',
                        icon: 'success',
                        timer: 2500,
                        showConfirmButton: false
                    });           
                     window.location.reload(); // Reload jika ada error session
        });
    }
}

// Fungsi untuk menampilkan notifikasi
</script>
<script>
// Timer otomatis
function startTimer(endTime) {
    var countDownDate = new Date(endTime).getTime();
    
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        
        // Hitung waktu tersisa
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Tampilkan timer
        document.getElementById("quiz-timer").innerHTML = 
            hours + "h " + minutes + "m " + seconds + "s ";
        
        // Jika waktu habis
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("quiz-timer").innerHTML = "WAKTU HABIS";
            alert("Waktu pengerjaan quiz telah habis!");
            document.getElementById("quiz-form").submit();
        }
    }, 1000);
}

// Jalankan timer saat halaman dimuat
window.onload = function() {
    startTimer("<?= $quiz_siswa->end_time ?>");
};
</script>
</body>
</html?