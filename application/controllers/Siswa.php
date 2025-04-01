<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('disqus');
        $this->load->model('M_materi');
        $this->load->model('Quiz_model');
    }
    public function start_quiz($quiz_id)
    {
        $this->load->model('Quiz_model');
        
        // Debug: Cek parameter yang diterima
        log_message('debug', 'Quiz ID: '.$quiz_id);
        
        // Ambil data siswa
        $siswa = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row();
        
        if(!$siswa) {
            show_error('Data siswa tidak ditemukan', 404);
        }
        
        // Cek quiz
        $quiz = $this->Quiz_model->get_quiz_with_questions($quiz_id);
        
        if(!$quiz) {
            show_404();
        }
        
        // Mulai quiz
        $quiz_siswa_id = $this->Quiz_model->start_quiz(
            $quiz_id, 
            $siswa->nis,
            $quiz->waktu_pengerjaan
        );
        
        redirect('siswa/do_quiz/'.$quiz_siswa_id);
    }

public function lanjutkan_quiz($quiz_siswa_id)
{
    $this->load->model('Quiz_model');
    
    // Ambil data quiz siswa
    $quiz_siswa = $this->Quiz_model->get_quiz_siswa($quiz_siswa_id);
    $siswa = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row();
    
    // Validasi
    if(!$quiz_siswa || $quiz_siswa->siswa_id != $siswa->nis) {
        show_404();
    }
    
    if($quiz_siswa->status == 'completed') {
        redirect("materi/quiz_result/{$quiz_siswa_id}");
    }
    $current_time = time();
    $end_time = strtotime($quiz_siswa->end_time);
    
    if($current_time > $end_time) {
        // Hitung nilai dari jawaban yang sudah dikerjakan
        $nilai = $this->Quiz_model->hitung_nilai_terakhir($quiz_siswa_id);
        
        // Submit otomatis
        $this->Quiz_model->complete_quiz($quiz_siswa_id, $nilai);
        
        // Set notifikasi
        $this->session->set_flashdata('timeout', 'Waktu pengerjaan quiz telah habis! ' . 
            ($nilai > 0 ? 'Nilai akhir: ' . $nilai : 'Anda tidak mengisi jawaban apapun.'));
        
        redirect("materi/quiz_result/{$quiz_siswa_id}");
    }
    
    redirect("materi/do_quiz/{$quiz_siswa_id}");
}

public function do_quiz($quiz_siswa_id)
{
    $this->load->model('Quiz_model');
    
    // Debug
    log_message('debug', 'Method do_quiz dipanggil dengan ID: '.$quiz_siswa_id);
    
    // Ambil data siswa
    $siswa = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row();
    
    // Ambil data quiz siswa
    $quiz_siswa = $this->Quiz_model->get_quiz_siswa($quiz_siswa_id);
    
    // Validasi
    if(!$quiz_siswa || $quiz_siswa->siswa_id != $siswa->nis) {
        log_message('error', 'Akses tidak valid ke quiz siswa ID: '.$quiz_siswa_id);
        show_404();
    }
    
    // Cek waktu
    if(strtotime($quiz_siswa->end_time) < time()) {
        $this->Quiz_model->complete_quiz($quiz_siswa_id, 0);
        redirect('siswa/quiz_result/'.$quiz_siswa_id);
    }
    
    // Ambil data quiz
    $data['quiz'] = $this->Quiz_model->get_quiz_with_questions($quiz_siswa->quiz_id);
    $data['quiz_siswa_id'] = $quiz_siswa_id;
    $data['time_left'] = strtotime($quiz_siswa->end_time) - time();
    
    // Debug data
    log_message('debug', 'Data quiz: '.print_r($data['quiz'], true));
    // Tambahkan debug ini sebelum load view

    $this->load->view('materi/navm');
    $this->load->view('materi/do_quiz', $data);
    
}


public function submit_quiz()
{
    $this->load->model('Quiz_model');
    
    $quiz_siswa_id = $this->input->post('quiz_siswa_id');
    $quiz_id = $this->input->post('quiz_id');
    
    // Proses jawaban
    $questions = $this->db->get_where('quiz_questions', ['quiz_id' => $quiz_id])->result();
    $total_score = 0;
    
    foreach($questions as $question) {
        $jawaban = $this->input->post('jawaban_'.$question->id);
        $poin = 0;
        
        if($question->tipe == 'pilihan' && $jawaban == $question->jawaban) {
            $poin = $question->poin;
        }
        
        $this->Quiz_model->submit_answer([
            'quiz_siswa_id' => $quiz_siswa_id,
            'question_id' => $question->id,
            'jawaban' => $jawaban,
            'poin_diperoleh' => $poin
        ]);
        
        $total_score += $poin;
    }
    
    // Hitung nilai akhir
    $max_score = array_sum(array_column($questions, 'poin'));
    $final_score = ($max_score > 0) ? ($total_score / $max_score) * 100 : 0;
    
    // Selesaikan quiz
    $this->Quiz_model->complete_quiz($quiz_siswa_id, $final_score);
    
    redirect("siswa/quiz_result/{$quiz_siswa_id}");
}

public function quiz_result($quiz_siswa_id)
{
    $this->load->model('Quiz_model');
    
    $data['result'] = $this->Quiz_model->get_quiz_result_detail($quiz_siswa_id);
    $siswa = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row();
    
    if(!$data['result'] || $data['result']->siswa_id != $siswa->nis) {
        show_404();
    }
    
    $this->load->view('materi/navm');
    $this->load->view('materi/quiz_result', $data);
}
}