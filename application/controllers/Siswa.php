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
        $this->load->model('M_siswa');
        $this->load->model('Tugas_model');
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
public function upload_tugas($materi_id) {
    $config['upload_path'] = './assets/materi_tugas/';
    $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
    $config['max_size'] = 5120; // 5MB
    $config['encrypt_name'] = true;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file_tugas')) {
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', $error);
    } else {
        $upload_data = $this->upload->data();
        
        $data = [
            'siswa_id' => $this->session->userdata('nis'),
            'materi_id' => $materi_id,
            'file_path' => 'assets/materi_tugas/' . $upload_data['file_name'],
            'original_filename' => pathinfo($upload_data['client_name'], PATHINFO_FILENAME) . ' (' . strtoupper(ltrim($upload_data['file_ext'], '.')) . ')',
            'file_type' => $upload_data['file_type'],
            'file_size' => $upload_data['file_size'],
            'dikirim_pada' => date('Y-m-d H:i:s')
        ];

        if ($this->Tugas_model->upload_tugas($data)) {
            $this->session->set_flashdata('success', 'Tugas berhasil diupload');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data tugas');
        }
    }

    redirect('materi/belajar/' . $materi_id);
}

// Hapus tugas
public function delete_tugas($id) {
    $tugas = $this->Tugas_model->get_tugas_siswa($id);
    
    // Cek kepemilikan
    if ($tugas && $tugas->siswa_id == $this->session->userdata('nis')) {
        if ($this->Tugas_model->delete_tugas($id)) {
            $this->session->set_flashdata('success', 'Tugas berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tugas');
        }
    } else {
        $this->session->set_flashdata('error', 'Anda tidak memiliki akses');
    }
    
    redirect('materi/belajar/' . $tugas->materi_id);
}
public function edit_profile() {
    $nis = $this->session->userdata('nis');
    $data['siswa'] = $this->M_siswa->get_by_nis($nis);

    $this->load->view('user/navu');
    $this->load->view('user/profile', $data);
    $this->load->view('user/foots');
}

public function update_profile()
{
    $nis = $this->input->post('nis');
    $nama = $this->input->post('nama');
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');


    // hanya validasi password jika user mengisinya
    if (!empty($password)) {
        $this->form_validation->set_rules('password', 'Password', 'min_length[8]');
    }

    if ($this->form_validation->run() == FALSE) {
        $data['siswa'] = $this->db->get_where('siswa', ['nis' => $nis])->row();
        $this->load->view('siswa/edit_profile', $data);
    } else {
        $updateData = [
            'nama' => $nama,
            'email' => $email
        ];

        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->where('nis', $nis);
        $this->db->update('siswa', $updateData);

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        redirect('siswa/edit_profile');
    }
}

public function email_check($email)
{
    $nis = $this->input->post('nis');
    $this->db->where('email', $email);
    $this->db->where('nis !=', $nis); // pengecualian untuk dirinya sendiri
    $query = $this->db->get('siswa');

    if ($query->num_rows() > 0) {
        $this->form_validation->set_message('email_check', 'Email ini sudah digunakan oleh siswa lain.');
        return FALSE;
    } else {
        return TRUE;
    }
}


}