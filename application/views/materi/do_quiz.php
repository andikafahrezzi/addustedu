<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4><?= $quiz->judul ?></h4>
            <div id="countdown" class="h4 mb-0"></div>
        </div>
        
        <div class="card-body">
            <form id="quizForm" action="<?= site_url('siswa/submit_quiz') ?>" method="post">
                <input type="hidden" name="quiz_siswa_id" value="<?= $quiz_siswa_id ?>">
                <input type="hidden" name="quiz_id" value="<?= $quiz->id ?>">
                
                <?php foreach($quiz->questions as $index => $question): ?>
                <div class="mb-5 p-3 border rounded">
                    <h5>
                        <span class="badge badge-primary mr-2"><?= $index+1 ?></span>
                        <?= $question->pertanyaan ?>
                        <small class="text-muted">(<?= $question->poin ?> poin)</small>
                    </h5>
                    
                    <?php if($question->tipe == 'pilihan'): ?>
                        <div class="ml-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                       name="jawaban_<?= $question->id ?>" id="opsiA_<?= $question->id ?>" value="a" required>
                                <label class="form-check-label" for="opsiA_<?= $question->id ?>">
                                    A. <?= $question->opsi_a ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                       name="jawaban_<?= $question->id ?>" id="opsiB_<?= $question->id ?>" value="b">
                                <label class="form-check-label" for="opsiB_<?= $question->id ?>">
                                    B. <?= $question->opsi_b ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                       name="jawaban_<?= $question->id ?>" id="opsiC_<?= $question->id ?>" value="c">
                                <label class="form-check-label" for="opsiC_<?= $question->id ?>">
                                    C. <?= $question->opsi_c ?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                       name="jawaban_<?= $question->id ?>" id="opsiD_<?= $question->id ?>" value="d">
                                <label class="form-check-label" for="opsiD_<?= $question->id ?>">
                                    D. <?= $question->opsi_d ?>
                                </label>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <textarea class="form-control" name="jawaban_<?= $question->id ?>" 
                                      rows="3" required></textarea>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa fa-paper-plane mr-2"></i>Kirim Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Timer countdown
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            document.getElementById('quizForm').submit();
        }
    }, 1000);
}

window.onload = function () {
    var timeLeft = <?= $time_left ?>;
    var display = document.querySelector('#countdown');
    startTimer(timeLeft, display);
};
</script>