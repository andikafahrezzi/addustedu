<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
         if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'siswa') {
            redirect('welcome');
        }
        $this->load->library('form_validation');
        $this->load->library('disqus');
        $this->load->library('email');
        $this->load->model('M_materi');
        $this->load->model('M_siswa');
        $this->load->model('Tugas_model');
        $this->load->model('Forum_model');
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
        
        redirect("siswa/quiz_result/{$quiz_siswa_id}");
    }
    
    redirect("siswa/do_quiz/{$quiz_siswa_id}");
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
    public function upload_tugas($id_pertemuan) {
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
                'id_pertemuan' => $id_pertemuan,
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

        redirect('materi/belajar/' . $id_pertemuan);
    }

// Hapus tugas
public function delete_tugas($id) {
    $this->load->model('Tugas_model');
    $tugas = $this->Tugas_model->get_tugas_by_id($id);

    if ($tugas && $tugas->siswa_id == $this->session->userdata('nis')) {
        $berhasil = $this->Tugas_model->delete_tugas($id);

        if ($berhasil) {
            $this->session->set_flashdata('success', 'Tugas berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tugas dari database.');
        }

        redirect('siswa/belajar/' . $tugas->id_pertemuan);
    } else {
        $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus tugas ini.');
        redirect('siswa/dashboard');
        log_message('debug', 'ID tugas: ' . $id);
log_message('debug', 'Siswa login: ' . $this->session->userdata('nis'));
if ($tugas) {
    log_message('debug', 'Tugas ditemukan. siswa_id: ' . $tugas->siswa_id . ', id_pertemuan: ' . $tugas->id_pertemuan);
} else {
    log_message('error', 'Tugas tidak ditemukan di DB.');
}

    }
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

        $this->M_siswa->update_profile($nis, $updateData);;

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
    public function belajar($id_pertemuan = null) {
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model', 'Tugas_model']);
            if ($id_pertemuan === null) {
            show_404(); // atau redirect ke halaman aman
            }

        // Ambil data
        $data['id_pertemuan'] = $id_pertemuan; // ✅ ini harus ada
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
        $data['disqus'] = $this->disqus->get_html();
        $data['quizzes'] = $this->Quiz_model->get_quizzes_by_materi($id_pertemuan);
        $data['materi_id'] = $this->M_materi->get_all_materi_idd();
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
public function tambah_komentar() {
    // Pastikan user sudah login
    $this->load->library('email');

    if (!$this->session->userdata('logged_in')) {
        redirect('welcome');
    }

    // Debug session - bisa dihapus setelah fix

    $user_type = $this->session->userdata('user_type');
    
    // Validasi user_type
    if (!in_array($user_type, ['siswa', 'guru'])) {
        $this->session->set_flashdata('error', 'Tipe user tidak valid');
        redirect('welcome');
    }

    $user_id = ($user_type === 'siswa') ? $this->session->userdata('nis') : $this->session->userdata('nip');
    
    // Data user
    if ($user_type === 'siswa') {
        $user = $this->db->get_where('siswa', ['nis' => $user_id])->row_array();
        if (!$user) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan');
            redirect('siswa/dashboard');
        }
        $user_name = $user['nama'];
    } else {
        $user = $this->db->get_where('guru', ['nip' => $user_id])->row_array();
        if (!$user) {
            $this->session->set_flashdata('error', 'Data guru tidak ditemukan');
            redirect('guru/dashboard');
        }
        $user_name = $user['nama_guru'];
    }

    // Validasi form
    $this->form_validation->set_rules('komentar', 'Komentar', 'required');
    $this->form_validation->set_rules('id_pertemuan', 'ID Pertemuan', 'required|numeric');
    $this->form_validation->set_rules('parent_id', 'Parent ID', 'numeric');

    if ($this->form_validation->run()) {
        $data = [
            'user_type' => $user_type,
            'user_id' => $user_id,
            'id_pertemuan' => $this->input->post('id_pertemuan'),
            'komentar' => $this->input->post('komentar'),
            'parent_id' => $this->input->post('parent_id') ?: NULL,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $id_pertemuan = $this->input->post('id_pertemuan');
        $komentar = $this->input->post('komentar');
        $guru = $this->Forum_model->getGuruByMateri($id_pertemuan);
        if (!$guru || empty($guru->email)) {
            $this->session->set_flashdata('error', 'Email guru tidak ditemukan.');
            redirect('materi/belajar/' . $id_pertemuan);
        }
    
        $this->email->from('noreply@addustedu', 'E-Learning');
        $this->email->to($guru->email);
        $this->email->subject('Komentar Baru di Forum Diskusi');
        $this->email->message("Ada komentar baru dari siswa di forum materi: <b>{$id_pertemuan}</b><br><br>Komentar:<br>{$komentar}");
    
        if (!$this->email->send()) {
            $this->session->set_flashdata('error', 'Komentar terkirim, tapi email gagal dikirim.');
            log_message('error', print_r($this->email->print_debugger(), true)); // log error ke log CI
        }

        if ($this->Forum_model->tambah_komentar($data)) {
            $this->session->set_flashdata('success', 'Komentar berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan komentar');
        }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }


        // Ganti bagian redirect akhir menjadi:
        $id_pertemuan = $this->input->post('id_pertemuan');
        if ($user_type === 'siswa') {
            redirect('siswa/belajar/' . $id_pertemuan); // Pastikan id_pertemuan ada
        } else {
            redirect('guru/belajar/' . $id_pertemuan);
        }
        }
public function edit_komentar() {
    $nis = $this->session->userdata('nis');
    if (!$nis) redirect('siswa/login');

    $this->load->model('Forum_model');
    $comment_id = $this->input->post('comment_id');

    $user_type = $this->session->userdata('user_type'); // 'siswa' atau 'guru'
$user_id = ($user_type === 'siswa') 
    ? $this->session->userdata('nis') 
    : $this->session->userdata('nip');

if (!$this->Forum_model->can_edit_comment($comment_id, $user_type, $user_id)) {
    $this->session->set_flashdata('error', 'Anda tidak memiliki izin mengedit komentar ini');
    redirect($_SERVER['HTTP_REFERER']);
}


    $this->form_validation->set_rules('komentar', 'Komentar', 'required');

    if ($this->form_validation->run()) {
        $data = [
            'komentar' => $this->input->post('komentar'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Forum_model->edit_komentar($comment_id, $data)) {
            $this->session->set_flashdata('success', 'Komentar berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui komentar');
        }
    } else {
        $this->session->set_flashdata('error', validation_errors());
    }

    redirect($_SERVER['HTTP_REFERER']);
}

public function hapus_komentar($id) {
    $nis = $this->session->userdata('nis');
    if (!$nis) redirect('siswa/login');

    $this->load->model('Forum_model');
    
    if ($this->Forum_model->can_edit_comment($id, "siswa", $nis)) {
        if ($this->Forum_model->hapus_komentar($id)) {
            $this->session->set_flashdata('success', 'Komentar berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus komentar');
        }
    } else {
        $this->session->set_flashdata('error', 'Anda tidak memiliki izin menghapus komentar ini');
    }

    redirect($_SERVER['HTTP_REFERER']);
}


}