<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Quiz_model');
        $this->load->library('form_validation');
    }

    // Tampilkan daftar quiz untuk materi tertentu
    public function index($materi_id) {
        $data['quizzes'] = $this->Quiz_model->get_quizzes_by_materi($materi_id);
        $data['materi'] = $this->db->get_where('materi', ['id' => $materi_id])->row();
        
        $this->load->view('templates/header');
        $this->load->view('quiz/index', $data);
        $this->load->view('templates/footer');
    }

    // Mulai mengerjakan quiz
    public function start($quiz_id) {
        // Cek apakah sudah pernah mengerjakan
        $user_id = $this->session->userdata('id');
        $existing = $this->Quiz_model->check_existing_result($quiz_id, $user_id);
        
        if($existing) {
            redirect('quiz/result/'.$existing->id);
        }

        $data['quiz'] = $this->Quiz_model->get_quiz_with_questions($quiz_id);
        
        $this->load->view('templates/header');
        $this->load->view('quiz/start', $data);
        $this->load->view('templates/footer');
    }

    // Submit jawaban quiz
    public function submit() {
        $this->form_validation->set_rules('quiz_id', 'Quiz ID', 'required');
        
        if ($this->form_validation->run()) {
            $result_id = $this->Quiz_model->save_quiz_result();
            redirect('quiz/result/'.$result_id);
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    // Lihat hasil quiz
    public function result($result_id) {
        $data['result'] = $this->Quiz_model->get_quiz_result($result_id);
        
        $this->load->view('templates/header');
        $this->load->view('quiz/result', $data);
        $this->load->view('templates/footer');
    }
    public function get_quizzes_by_materi($materi_id)
    {
        return $this->db->select('quiz.*, COUNT(quiz_questions.id) as jumlah_soal')
                       ->from('quiz')
                       ->join('quiz_questions', 'quiz_questions.quiz_id = quiz.id', 'left')
                       ->where('quiz.materi_id', $materi_id)
                       ->group_by('quiz.id')
                       ->get()
                       ->result();
    }
    
    public function get_quiz_result($quiz_id, $siswa_id)
    {
        return $this->db->get_where('quiz_siswa', [
            'quiz_id' => $quiz_id,
            'siswa_id' => $siswa_id
        ])->row();
    }
}