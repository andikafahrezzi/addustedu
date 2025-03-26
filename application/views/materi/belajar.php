

    <!-- Start Greeting Cards -->
    <div class="container">
        <div class="bg-white mt-25 p-5 buat-text" data-aos="fade-down" data-aos-duration="1400" style="width: 100%; border-radius:10px;">
            <div class="row" style="color: black; font-family: 'poppins';">
                <div class="col-md-12 mt-1 ml-4">
                    <h1 class="display-4" style="color: black; font-family:'poppins';" data-aos="fade-down" data-aos-duration="1400">Selamat Belajar !
                    </h1>
                    <h4 data-aos="fade-down" data-aos-duration="1700"><?php
                                                                        $data['user'] = $this->db->get_where('siswa', ['nis' =>
                                                                        $this->session->userdata('nis')])->row_array();
                                                                        echo $data['user']['nama'];
                                                                        ?> - addustedu Students</h3>
                        <p><?= $materi->nama_mapel ?> - Kelas <?= $materi->kelas ?></p>
                        <hr align="left" width="600;">
                        
                </div>
            </div>
        </div>
    </div>
    <!-- End Greeting Cards -->
    <div class="row about_inner">
                        <div class="col-lg-10 ml-lg-5">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <p class="kotakp"><span class="lnr lnr-file-empty font-size-4"></span> Link Tugas</p>
                                            <i class="lnr lnr-chevron-down"></i>
                                            <i class="lnr lnr-chevron-up"></i>
                                        </button>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                        <p class="font-weight-bold"><a href="<?= substr($materi->linkform, 0, 120); ?>" target="_blank"><?= substr($materi->linkform, 0, 120); ?></a>
                                        
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <p class="kotakp"><span class="lnr lnr-users"></span> Link Materi</p>
                                            <i class="lnr lnr-chevron-down"></i>
                                            <i class="lnr lnr-chevron-up"></i>
                                        </button>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                        <div class="card-body">
                                        <div class="font-weight-bold">
                                            <?php 
                                                $modulPath = 'assets/materi_modul/' . trim($materi->modul); // Path relatif
                                                if (!empty($materi->modul) && file_exists(FCPATH . $modulPath)): 
                                            ?>
                                                <a href="<?= base_url($modulPath) ?>" target="_blank" class="btn btn-primary">📖 Lihat Modul</a> <br>
                                                <a href="<?= base_url($modulPath) ?>" download class="btn btn-success">⬇️ Download Modul</a>
                                            <?php else: ?>
                                                <p class="text-danger">❌ Modul belum tersedia</p>
                                            <?php endif; ?>
                                        </div>
                                        </div>
                                    </div>
                                <br>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <p class="kotakp"><span class="lnr lnr-users"></span> Forum Diskusi</p>
                                            <i class="lnr lnr-chevron-down"></i>
                                            <i class="lnr lnr-chevron-up"></i>
                                        </button>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p style="line-height: 3px;">Kita akan mempelajari tentang</p>
                                            

                                                <!-- Start Video Player -->
                                        <div class="container mt-4">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto text-center">
                                                    <video id="myvideo" width="100%" height="auto" controls>
                                                        <source src="<?= base_url() . 'assets/materi_video/' . $materi->video; ?>" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        

                                        <!-- Scripts -->
                                        
                                        <!-- End Video Player -->
                                        <!-- Start Deskripsi Materi -->
                                        <div class="container">
                                            <div class="row mt-4">
                                                <div class="col-md-12 w-150 mb-4">
                                                    <div class="card materi border-0">
                                                        <div class="card-body p-5">
                                                            <h1 class="card-title display-4"><?= $materi->nama_guru; ?></h1>
                                                            <hr style="background-color: white;">
                                                            <h5 class="card-text"><?= $materi->nama_mapel; ?></h5>
                                                            <p class="card-text"> Deskripsi materi pelajaran : <br> <?= $materi->deskripsi; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                       <!-- Forum Diskusi -->
<div class="container">
    <div class="card mt-4">
        <div class="card-body">
            <h2>Forum Diskusi</h2>
            <?php 
// Pastikan $materi ada sebelum mengakses propertinya
if(!isset($materi) || !is_object($materi)) {
    die('Data materi tidak valid');
}
?>

<!-- Form Tambah Komentar -->
<form method="POST" action="<?= base_url('forum/tambah_komentar') ?>">
    <input type="hidden" name="materi_id" value="<?= $materi->id ?>">
    <input type="hidden" name="parent_id" value="">
    
    <div class="form-group">
        <label for="komentar">Komentar:</label>
        <textarea class="form-control" name="komentar" required></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Kirim</button>
</form>

<!-- Fungsi tampil komentar -->
<?php 
function display_comments($comments, $materi_id, $level = 0) {
    foreach ($comments as $comment) {
        $margin = $level * 20;
?>
        <div class="card mt-2" style="margin-left: <?= $margin ?>px;">
            <div class="card-body">
                <p><strong><?= htmlspecialchars($comment->user) ?></strong> (<?= $comment->tanggal ?>)</p>
                <p><?= nl2br(htmlspecialchars($comment->komentar)) ?></p>
                
                <button class="btn btn-sm btn-link" onclick="toggleReplyForm(<?= $comment->id ?>)">
                    Balas
                </button>

                <div id="reply-form-<?= $comment->id ?>" style="display: none;">
                    <form method="POST" action="<?= base_url('forum/tambah_komentar') ?>">
                        <input type="hidden" name="materi_id" value="<?= $materi_id ?>">
                        <input type="hidden" name="parent_id" value="<?= $comment->id ?>">
                        
                        <div class="form-group mt-2">
                            <textarea class="form-control" name="komentar" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                    </form>
                </div>

                <?php if (!empty($comment->replies)): ?>
                    <?php display_comments($comment->replies, $materi_id, $level + 1); ?>
                <?php endif; ?>
            </div>
        </div>
<?php
    }
}

// Panggil fungsi tampil komentar
if (!empty($forum)) {
    display_comments($forum, $materi->id);
} else {
    echo "<p class='mt-3'>Belum ada komentar.</p>";
}
?>

<script>
function toggleReplyForm(commentId) {
    var form = document.getElementById("reply-form-" + commentId);
    if (form) {
        form.style.display = (form.style.display === "none") ? "block" : "none";
    }
}
</script>
            
        </div>
    </div>
</div>

<script>
function toggleReplyForm(commentId) {
    var form = document.getElementById("reply-form-" + commentId);
    if (form) {
        form.style.display = (form.style.display === "none") ? "block" : "none";
    }
}
</script>
                                        <!-- End Deskripsi Materi -->


                                        <br>


                                        <!-- Start Disqus Comment -->
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card komen w-150 border-0">
                                                        <div class="card-body p-5" style="font-family: 'Poppins', sans-serif !important;">
                                                            <h1 style="color: black; font-size:44px !important;">Apa komentarmu ?</h1>
                                                            <br>
                                                            <?php echo $disqus ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>


    <!-- Start Disqus Comment -->


    <br>
    <br>
    <br>


    <!-- Start Animate On Scroll -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
function toggleReplyForm(commentId) {
    var form = document.getElementById("reply-form-" + commentId);
    if (form) {
        form.style.display = (form.style.display === "none") ? "block" : "none";
    } else {
        console.error("Form reply dengan ID " + commentId + " tidak ditemukan!");
    }
}
</script>

    <!-- <script>
        const video = document.getElementById('myvideo');
        const progressBar = document.getElementById('progress-bar');

        // Play video
        function playVideo() {
            video.play();
        }

        // Pause video
        function pauseVideo() {
            video.pause();
        }

        // Rewind video (10 seconds back)
        function rewindVideo() {
            video.currentTime -= 10;
        }

        // Update progress bar
        video.addEventListener('timeupdate', () => {
            const progress = (video.currentTime / video.duration) * 100;
            progressBar.value = progress;
        });

        // Seek video
        progressBar.addEventListener('input', () => {
            const seekTime = (progressBar.value / 100) * video.duration;
            video.currentTime = seekTime;
        });
    </script> -->
    <!-- End Animate On Scroll -->