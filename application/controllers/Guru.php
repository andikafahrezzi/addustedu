<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->session->set_flashdata('not-login', 'Gagal!');
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model', 'Tugas_model', 'M_siswa']);  
        $this->load->library('form_validation');
        if (!$this->session->userdata('nip')) {
            redirect('welcome/guru');
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('guru', ['nip' => $this->session->userdata('nip')])->row_array();
        $this->load->view('guru/navug');
        $this->load->view('guru/index');
        $this->load->view('guru/footg');

    }

    public function add_materi()
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required');
    $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required|numeric');
    
    $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);

    if ($this->form_validation->run() == false) {
        $nip = $this->session->userdata('nip');
        $data['user'] = $this->db->get_where('guru', ['nip' => $nip])->row_array();
        $this->load->view('guru/navug');
        $this->load->view('guru/add_materi', $data);
        $this->load->view('guru/footg');
    } else {
        $pertemuan = $this->input->post('pertemuan');
        $kelas = $this->input->post('kelas');
        $mapel = $this->input->post('nama_mapel');
        $nip = $this->session->userdata('nip');

        //  Validasi pertemuan tidak duplikat
        $cek_duplikat = $this->db->get_where('materi', [
            'pertemuan' => $pertemuan,
            'kelas' => $kelas,
            'nama_mapel' => $mapel,
            'id_guru' => $nip
        ])->row();

        if ($cek_duplikat) {
            $this->session->set_flashdata('error', 'Pertemuan ke-' . $pertemuan . ' untuk kelas dan mapel ini sudah ada.');
            redirect('guru/add_materi');
        }

        // Upload video
        $this->load->library('upload');
        $video_materi = '';
        if (!empty($_FILES['video']['name'])) {
            $config_video['upload_path']   = './assets/materi_video/';
            $config_video['allowed_types'] = 'mp4|avi|mov|wmv|mkv|webm';
            $config_video['max_size']      = 100000;
            $this->upload->initialize($config_video);

            if ($this->upload->do_upload('video')) {
                $upload_data = $this->upload->data();
                $video_materi = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload video: ' . $this->upload->display_errors());
                redirect('guru/add_materi');
            }
        }

        // Upload file materi
        $modul = '';
        if (!empty($_FILES['modul']['name'])) {
            $config_modul['upload_path']   = './assets/materi_modul/';
            $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
            $config_modul['max_size']      = 2048;
            $this->upload->initialize($config_modul);

            if ($this->upload->do_upload('modul')) {
                $upload_data = $this->upload->data();
                $modul = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
                redirect('guru/add_materi');
            }
        }

        // Simpan ke database
        $data = [
            'id_guru'     => $nip,
            'nama_guru'   => htmlspecialchars($this->input->post('nama_guru', true)),
            'nama_mapel'  => htmlspecialchars($this->input->post('nama_mapel', true)),
            'kelas'       => htmlspecialchars($this->input->post('kelas', true)),
            'pertemuan'   => $pertemuan,
            'video'       => $video_materi,
            'modul'       => $modul,
            'deskripsi'   => htmlspecialchars($this->input->post('deskripsi', true)),
            'linkform'    => htmlspecialchars($this->input->post('linkform', true)),
        ];

        $this->db->insert('materi', $data);
        $this->session->set_flashdata('success', 'Materi berhasil ditambahkan!');
        redirect('guru');
    }
}


    private function _uploadImage()
    {
        $config['upload_path'] = './assets/materi_video';
        $config['allowed_types'] = 'mp4|mkv';
        $config['file_name'] = $this->product_id;
        $config['overwrite'] = true;
        $config['max_size'] = 0; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            return $this->upload->data("file_name");
        }

        return "default.mp4";
    }

    public function data_materi()
{
    $this->load->model('m_materi');
    
    // Ambil NIP guru yang login dari session
    $nip = $this->session->userdata('nip');
    
    // Ambil data guru
    $data['user'] = $this->db->get_where('guru', ['nip' => $nip])->row_array();
    
    // Ambil materi yang hanya dibuat oleh guru ini
    $data['materi'] = $this->m_materi->tampil_materi_guru($nip)->result();
    
    $this->load->view('guru/navug');
    $this->load->view('guru/data_materi', $data);
    $this->load->view('guru/footg');
}

public function update_materi($id)
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required');
    $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required|numeric');
    $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);

    if ($this->form_validation->run() == false) {
        $nip = $this->session->userdata('nip');
        $data['user'] = $this->db->get_where('guru', ['nip' => $nip])->row_array();
        $data['materi'] = $this->M_materi->get_materi_by_ids($id)->row();
        
        $this->load->view('guru/navug');
        $this->load->view('guru/update_materi', $data);
        $this->load->view('guru/footg');
    } else {
        $this->load->library('upload');

        $nip = $this->session->userdata('nip');
        $guru = $this->db->get_where('guru', ['nip' => $nip])->row_array();

        $pertemuan = $this->input->post('pertemuan');
        $kelas = $this->input->post('kelas');
        $mapel = $this->input->post('nama_mapel');

        // 🔁 Cek duplikat pertemuan
        $cek_duplikat = $this->db->get_where('materi', [
            'pertemuan' => $pertemuan,
            'kelas' => $kelas,
            'nama_mapel' => $mapel,
            'id_guru' => $nip
        ])->row();

        if ($cek_duplikat) {
            $this->session->set_flashdata('error-per', 'Pertemuan ke-' . $pertemuan . ' untuk kelas dan mapel ini sudah ada.');
            redirect('guru/update_materi/' . $id);
        }

        // ✅ Upload Video
        $video_materi = '';
        if (!empty($_FILES['video']['name'])) {
            $config_video['upload_path']   = './assets/materi_video/';
            $config_video['allowed_types'] = 'mp4|avi|mov|wmv|mkv|webm';
            $config_video['max_size']      = 100000;

            $this->upload->initialize($config_video);

            if ($this->upload->do_upload('video')) {
                $upload_data = $this->upload->data();
                $video_materi = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload video: ' . $this->upload->display_errors());
                redirect('guru/update_materi/' . $id);
            }
        }

        // ✅ Upload Modul
        $modul = '';
        if (!empty($_FILES['modul']['name'])) {
            $config_modul['upload_path']   = './assets/materi_modul/';
            $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
            $config_modul['max_size']      = 2048;

            $this->upload->initialize($config_modul);

            if ($this->upload->do_upload('modul')) {
                $upload_data = $this->upload->data();
                $modul = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
                redirect('guru/update_materi/' . $id);
            }
        }

        // ✅ Simpan ke database
        $data = [
            'nama_guru'   => htmlspecialchars($this->input->post('nama_guru', true)),
            'nama_mapel'  => htmlspecialchars($mapel),
            'pertemuan'   => $pertemuan,
            'video'       => $video_materi,
            'modul'       => $modul,
            'deskripsi'   => htmlspecialchars($this->input->post('deskripsi', true)),
            'linkform'    => htmlspecialchars($this->input->post('linkform', true)),
            'kelas'       => htmlspecialchars($kelas)
        ];

        $this->db->where('id_materi', $id);
        $this->db->update('materi', $data);

        $this->session->set_flashdata('success', 'Materi berhasil diperbarui!');
        redirect('guru');
    }
}

    
    public function materi_edit()
{
    $this->load->model('m_materi');
    $this->load->library('form_validation');

    // Validasi form input
    $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, kembali ke halaman edit
        $id = $this->input->post('id');
        $this->session->set_flashdata('error', validation_errors());
        redirect('guru/update_materi/' . $id);
        return;
    }

    // Ambil data input
    $id          = $this->input->post('id');
    $pertemuan   = $this->input->post('pertemuan');
    $kelas       = $this->input->post('kelas');
    $mapel       = $this->input->post('nama_mapel');
    $nip         = $this->input->post('id_guru');
    $nama_guru   = $this->input->post('nama_guru');
    $deskripsi   = $this->input->post('deskripsi');
    $linkform    = $this->input->post('linkform');

    // Cek apakah pertemuan ke-x sudah dipakai guru, mapel, dan kelas lain
    $cek_duplikat = $this->db
        ->where('pertemuan', $pertemuan)
        ->where('kelas', $kelas)
        ->where('nama_mapel', $mapel)
        ->where('id_guru', $nip)
        ->where('id !=', $id) // hindari id sendiri
        ->get('materi')
        ->row();

    if ($cek_duplikat) {
        $this->session->set_flashdata('error-per', 'Pertemuan ke-' . $pertemuan . ' sudah dipakai untuk mapel dan kelas ini.');
        redirect('guru/update_materi/' . $id);
        return;
    }

    // ---------------- Upload Video ----------------
    $video = '';
    if (!empty($_FILES['video']['name'])) {
        $config['upload_path']   = './assets/materi_video/';
        $config['allowed_types'] = 'mp4|avi|mov|wmv|mkv';
        $config['max_size']      = 102400;

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('video')) {
            $video = $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('guru/update_materi/' . $id);
            return;
        }
    } else {
        $video = $this->db->get_where('materi', ['id' => $id])->row()->video;
    }

    // ---------------- Upload Modul ----------------
    $modul = '';
    if (!empty($_FILES['modul']['name'])) {
        $config['upload_path']   = './assets/materi_modul/';
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
        $config['max_size']      = 5120;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('modul')) {
            $modul = $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('guru/update_materi/' . $id);
            return;
        }
    } else {
        $modul = $this->db->get_where('materi', ['id' => $id])->row()->modul;
    }

    // ---------------- Update Data ----------------
    $data = [
        'id_guru'    => $nip,
        'nama_guru'  => $nama_guru,
        'nama_mapel' => $mapel,
        'kelas'      => $kelas,
        'pertemuan'  => $pertemuan,
        'deskripsi'  => $deskripsi,
        'linkform'   => $linkform,
        'video'      => $video,
        'modul'      => $modul
    ];

    $where = ['id' => $id];

    // Optional: Cek apakah ada perubahan data
    $existing_data = $this->db->get_where('materi', $where)->row_array();
    if ($existing_data) {
        $difference = array_diff_assoc($data, $existing_data);
        if (empty($difference)) {
            $this->session->set_flashdata('info', 'Tidak ada perubahan data.');
            redirect('guru/update_materi/' . $id);
            return;
        }
    }

    // Simpan ke DB
    $this->m_materi->update_data($where, $data, 'materi');
    $this->session->set_flashdata('success-edit', 'Materi berhasil diperbarui.');
    redirect('guru/data_materi');
}
public function delete_materi($id)
{
    // Load model dan helper
    $this->load->model('M_materi');
    $this->load->helper('file');

    // Ambil data materi berdasarkan ID
    $materi = $this->db->get_where('materi', ['id' => $id])->row();

    // Jika materi tidak ditemukan
    if (!$materi) {
        $this->session->set_flashdata('error', 'Data materi tidak ditemukan.');
        redirect('guru/data_materi');
        return;
    }

    // Hapus file video jika ada
    if ($materi->video && file_exists('./assets/materi_video/' . $materi->video)) {
        unlink('./assets/materi_video/' . $materi->video);
    }

    // Hapus file modul jika ada
    if ($materi->modul && file_exists('./assets/materi_modul/' . $materi->modul)) {
        unlink('./assets/materi_modul/' . $materi->modul);
    }

    // Hapus dari database
    $this->M_materi->delete_data(['id' => $id], 'materi');

    // Notifikasi berhasil
    $this->session->set_flashdata('success', 'Data materi berhasil dihapus.');
    redirect('guru/data_materi');
}



    //QUIZ
    public function data_quiz()
    {
        $nip = $this->session->userdata('nip');
        $data['quizzes'] = $this->Quiz_model->get_quizzes_by_guru($nip);
        $this->load->view('guru/navug');
        $this->load->view('guru/data_quiz', $data);
        $this->load->view('guru/footg');
    }

    public function buat_quiz_guru()
    {
        $this->load->model('Quiz_model');
        $nip = $this->session->userdata('nip');
        
        // Validasi form
        $this->form_validation->set_rules('materi_id', 'Materi', 'required');
        $this->form_validation->set_rules('judul', 'Judul Quiz', 'required|max_length[100]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[500]');
        $this->form_validation->set_rules('waktu_pengerjaan', 'Waktu Pengerjaan', 'required|numeric');
        $this->form_validation->set_rules('attempts', 'Percobaan Maksimal', 'required|numeric');
        
        if ($this->form_validation->run()) {
            $quiz_data = [
                'materi_id' => $this->input->post('materi_id'),
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'waktu_pengerjaan' => $this->input->post('waktu_pengerjaan'),
                'attempts' => $this->input->post('attempts'),
                'shuffle_questions' => $this->input->post('shuffle_questions') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $quiz_id = $this->Quiz_model->create_quiz($quiz_data);
            
            $this->session->set_flashdata('success', 'Quiz berhasil dibuat!');
            redirect('guru/kelola_quiz/'.$quiz_id);
        }
        
        $data['materi_list'] = $this->Quiz_model-> get_materi_options($nip);
        
        // Debug path view
        $view_path = APPPATH.'views/guru/add_quiz.php';
        if (!file_exists($view_path)) {
            show_error("View file not found: ".$view_path, 500, "View Error");
        }
        
        $this->load->view('guru/navug');
        $this->load->view('guru/add_quiz', $data);
        $this->load->view('guru/footg');
    }


    // Store new quiz
    public function store() {
        $nip = $this->session->userdata('nip');
        
        // Validate form input
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('materi_id', 'Materi', 'required');
        $this->form_validation->set_rules('waktu_pengerjaan', 'Waktu Pengerjaan', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            // Verify that the materi belongs to this teacher
            $materi_id = $this->input->post('materi_id');
            $materi_options = $this->Quiz_model->get_materi_options($nip);
            $valid_materi = array_column($materi_options, 'id');
            
            if (!in_array($materi_id, $valid_materi)) {
                $this->session->set_flashdata('error', 'Materi tidak valid');
                redirect('guru/data_quiz');
            }
            
            $data = [
                'materi_id' => $materi_id,
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'waktu_pengerjaan' => $this->input->post('waktu_pengerjaan'),
                'attempts' => $this->input->post('attempts'),
                'shuffle_questions' => $this->input->post('shuffle_questions') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->Quiz_model->create_quiz($data)) {
                $this->session->set_flashdata('success', 'Quiz berhasil dibuat');
                redirect('guru/data_quiz');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat quiz');
                redirect('guru/add_quiz');
            }
        }
    }

    // Edit quiz form
    public function edit_quiz($id) {
        $nip = $this->session->userdata('nip');
        $data['quizzes'] = $this->Quiz_model->get_quizzes_by_guru($nip);
        $data['quiz'] = $this->Quiz_model->get_quiz_by_guru($id, $nip);
        $data['materi_options'] = $this->Quiz_model->get_materi_options($nip);
        
        if (empty($data['quiz'])) {
            show_404();
        }
        $this->load->view('guru/navug');
        $this->load->view('guru/update_quiz', $data);
        $this->load->view('guru/footg');
    }

    // Update quiz
    public function update($id) {
        $nip = $this->session->userdata('nip');
        
        // First verify ownership
        $quiz = $this->Quiz_model->get_quiz_by_guru($id, $nip);
        if (empty($quiz)) {
            show_404();
        }
        
        // Validate form input
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('waktu_pengerjaan', 'Waktu Pengerjaan', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'waktu_pengerjaan' => $this->input->post('waktu_pengerjaan'),
                'attempts' => $this->input->post('attempts'),
                'shuffle_questions' => $this->input->post('shuffle_questions') ? 1 : 0
            ];
            
            if ($this->Quiz_model->update_quiz($id, $nip, $data)) {
                $this->session->set_flashdata('success', 'Quiz berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui quiz');
            }
            
            redirect('guru/data_quiz');
        }
    }
    public function kelola_quiz($quiz_id)
{
    $this->load->model('Quiz_model');
    
    // Tambahkan soal baru
    if ($this->input->post('pertanyaan')) {
        $this->tambah_soal($quiz_id);
    }
    
    $data['quiz'] = $this->Quiz_model->get_quiz_with_questions($quiz_id);
    
    if(empty($data['quiz'])) {
        show_404();
    }
    
    
    $this->load->view('guru/navug');  
    $this->load->view('guru/kelola_quiz', $data);
    $this->load->view('guru/footg');
}
private function tambah_soal($quiz_id)
{
    $this->load->model('Quiz_model');
    
    $tipe = $this->input->post('tipe');
    $data = [
        'quiz_id' => $quiz_id,
        'pertanyaan' => $this->input->post('pertanyaan'),
        'tipe' => $tipe,
        'poin' => $this->input->post('poin', true) ?: 1
    ];
    
    if ($tipe == 'pilihan') {
        $data['opsi_a'] = $this->input->post('opsi_a');
        $data['opsi_b'] = $this->input->post('opsi_b');
        $data['opsi_c'] = $this->input->post('opsi_c');
        $data['opsi_d'] = $this->input->post('opsi_d');
        $data['jawaban'] = $this->input->post('jawaban');
    }
    
    $this->Quiz_model->tambah_soal($data);
    $this->session->set_flashdata('success', 'Soal berhasil ditambahkan!');
}

    // Delete quiz
    public function delete($id) {
        $nip = $this->session->userdata('nip');
        
        if ($this->Quiz_model->delete_quiz($id, $nip)) {
            $this->session->set_flashdata('success', 'Quiz berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus quiz');
        }
        
        redirect('quiz');
    }
    public function lihat_tugas($materi_id) {
        $data['submissions'] = $this->Tugas_model->get_submissions($materi_id);
        $this->load->view('guru/navug'); 
        $this->load->view('guru/lihat_tugas', $data);
        $this->load->view('guru/footg');
    }

    // Beri nilai/catatan
    public function beri_nilai($submission_id) {
        $this->form_validation->set_rules('nilai', 'Nilai', 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        
        if ($this->form_validation->run()) {
            $data = [
                'nilai' => $this->input->post('nilai'),
                'catatan' => $this->input->post('catatan')
            ];
            
            if ($this->Tugas_model->update_nilai($submission_id, $data)) {
                $this->session->set_flashdata('success', 'Nilai berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui nilai');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }

    // Hapus tugas (oleh admin/guru)
    public function hapus_tugas($id) {
        if ($this->Tugas_model->delete_tugas($id)) {
            $this->session->set_flashdata('success', 'Tugas berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tugas');
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function daftar_tugas() {
        $this->load->model('Tugas_model');
    
        $data['materi_list'] = [];
        $materi_ids = $this->Tugas_model->get_all_materi_ids();
    
        foreach ($materi_ids as $row) {
            $data['materi_list'][$row->materi_id] = $this->Tugas_model->get_tugas_per_materi($row->materi_id);
        }
        $this->load->view('guru/navug'); 
        $this->load->view('guru/daftar_tugas_siswa', $data);
        $this->load->view('guru/footg');
    }
    public function edit_profile() {
        $nip = $this->session->userdata('nip');
        $data['guru'] = $this->M_siswa->get_by_nip($nip);
    
        $this->load->view('guru/navug');
        $this->load->view('guru/profile', $data);
        $this->load->view('guru/footg');
    }
    
    public function update_profile()
    {
        $nip = $this->input->post('nip');
        $nama_guru = $this->input->post('nama_guru');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        $this->form_validation->set_rules('nama_guru', 'Nama_guru', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
    
    
        // hanya validasi password jika user mengisinya
        if (!empty($password)) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[8]');
        }
    
        if ($this->form_validation->run() == FALSE) {
            $data['guru'] = $this->db->get_where('guru', ['nip' => $nip])->row();
            $this->load->view('guru/profile', $data);
        } else {
            $updateData = [
                'nama_guru' => $nama_guru,
                'email' => $email
            ];
    
            if (!empty($password)) {
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
    
            $this->M_siswa->update_profile_guru($nip, $updateData);
    
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
            redirect('guru/edit_profile');
        }
    }
    
    public function email_check($email)
    {
        $nip = $this->input->post('nip');
        $this->db->where('email', $email);
        $this->db->where('nip !=', $nip); // pengecualian untuk dirinya sendiri
        $query = $this->db->get('guru');
    
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_check', 'Email ini sudah digunakan oleh siswa lain.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    
}
