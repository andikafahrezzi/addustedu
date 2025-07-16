<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Materi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('disqus');
        $this->load->model('M_materi');
    }
    public function index() 
    {
        $query = $this->db->get_where('pertemuan', ['id' => $id_pertemuan]);

                if ($query->num_rows() > 0) {
                    $data['pertemuan'] = $query->row();
                } else {
                    $data['pertemuan'] = null; // Set null jika tidak ditemukan
                }

                $this->load->view('materi/belajar', $data);

    }
    // function generateMateri($materi){
    
    //     $data['materi'] = $this->list_materi[$materi];
    //     $data['user'] = $this->db->get_where('siswa', ['email' =>
    //         $this->session->userdata('email')])->row_array();
    //     $this->load->view('materi/navm');
    //     $this->load->view('materi/'.str_replace('_', '-', $materi), $data);
    //     $this->load->view('template/footer');
    // }
    public function belajar($id_pertemuan) {
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model', 'Tugas_model']);
            if ($id_pertemuan === null) {
            show_404(); // atau redirect ke halaman aman
            }

        // Ambil data
        $data['comments'] = $this->Forum_model->get_comments($id_pertemuan);
        $data['id_pertemuan'] = $id_pertemuan;
        $data['current_nis'] = $this->session->userdata('nis');
        $pertemuan = $this->db->get_where('pertemuan', ['id' => $id_pertemuan])->row_array();
        // if (!$pertemuan) show_404();
        if (!$pertemuan) {
        show_404(); // atau redirect('materi');
        }
        $id_materi = $pertemuan['id_materi'];
        $data['materi'] = $this->M_materi->get_materi_by_id($id_materi);

        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['forum'] = $this->Forum_model->get_komentar_by_materi($id_pertemuan);
        // $data['disqus'] = $this->disqus->get_html();
        $data['quizzes'] = $this->Quiz_model->get_quizzes_by_materi($id_pertemuan);
        $data['materi_id'] = $this->M_materi->get_all_materi_id();
        $data['tugas_saya'] = $this->Tugas_model->get_tugas_siswa(
            $this->session->userdata('nis'), 
            $id_pertemuan
        );

        
        // Debug akhir sebelum load view
        // if(empty($data['materi'])) {
        //     show_404();
        //     return;
        // }
        
        $this->load->view('materi/navm');
        $this->load->view('materi/belajar', $data);
        $this->load->view('materi/footm');

    }
    public function list_quiz()
{
    // Ambil data siswa dari session
    $siswa_id = $this->session->userdata('siswa_id');
    $kelas = $this->session->userdata('kelas');
    
    $this->load->model('Quiz_model');
    $data['quizzes'] = $this->Quiz_model->get_available_quizzes($kelas);
    
    $this->load->view('materi/navm');;
    $this->load->view('materi/belajar', $data);
}

public function start_quiz($quiz_id)
{
    $this->load->model('Quiz_model');
    
    // Cek apakah quiz tersedia untuk siswa ini
    $quiz = $this->Quiz_model->get_quiz_with_questions($quiz_id);
    $kelas_siswa = $this->session->userdata('kelas');
    
    if(!$quiz || $quiz->materi->kelas != $kelas_siswa) {
        show_404();
    }
    
    // Mulai quiz
    $quiz_siswa_id = $this->Quiz_model->start_quiz(
        $quiz_id, 
        $this->session->userdata('siswa_id'),
        $quiz->waktu_pengerjaan
    );
    
    redirect("materi/do_quiz/{$quiz_siswa_id}");
}

public function do_quiz($quiz_siswa_id)
{
    $this->load->model('Quiz_model');
    
    // Ambil data quiz siswa
    $quiz_siswa = $this->db->get_where('quiz_siswa', ['id' => $quiz_siswa_id])->row();
    
    // Validasi
    if(!$quiz_siswa || $quiz_siswa->siswa_id != $this->session->userdata('siswa_id')) {
        show_404();
    }
    
    // Cek waktu
    if(strtotime($quiz_siswa->end_time) < time()) {
        redirect("materi/quiz_completed/{$quiz_siswa_id}");
    }
    
    // Ambil data quiz
    $data['quiz'] = $this->Quiz_model->get_quiz_with_questions($quiz_siswa->quiz_id);
    $data['quiz_siswa_id'] = $quiz_siswa_id;
    $data['time_left'] = strtotime($quiz_siswa->end_time) - time();
    
    $this->load->view('materi/navm');;
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
    
    redirect("materi/quiz_completed/{$quiz_siswa_id}");
}

public function quiz_completed($quiz_siswa_id)
{
    $this->load->model('Quiz_model');
    
    $data['result'] = $this->db->select('quiz_siswa.*, quiz.judul, materi.nama_mapel')
                              ->from('quiz_siswa')
                              ->join('quiz', 'quiz.id = quiz_siswa.quiz_id')
                              ->join('materi', 'materi.id = quiz.materi_id')
                              ->where('quiz_siswa.id', $quiz_siswa_id)
                              ->where('quiz_siswa.siswa_id', $this->session->userdata('siswa_id'))
                              ->get()
                              ->row();
    
    if(!$data['result']) {
        show_404();
    }
    
    $this->load->view('materi/navm');
    $this->load->view('materi/quiz_result', $data);
}
}
