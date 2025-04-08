<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->session->set_flashdata('not-login', 'Gagal!');
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model', 'Tugas_model']);  
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
    $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);
    
    if ($this->form_validation->run() == false) {
        $nip = $this->session->userdata('nip'); // atau 'id_guru', sesuai yang kamu pakai

        // Ambil data user dari tabel guru
        $data['user'] = $this->db->get_where('guru', ['nip' => $nip])->row_array();
        $this->load->view('guru/navug');
        $this->load->view('guru/add_materi', $data);
        $this->load->view('guru/footg');
    } else {
        // Load library upload terlebih dahulu
        $this->load->library('upload');

        // **1️⃣ Proses Upload Video**
        $video_materi = '';
        if (!empty($_FILES['video']['name'])) {
            $config_video['upload_path']   = './assets/materi_video/';
            $config_video['allowed_types'] = 'mp4|avi|mov|wmv|mkv|webm';
            $config_video['max_size']      = 100000;

            $this->upload->initialize($config_video);

            if ($this->upload->do_upload('video')) {
                $upload_data = $this->upload->data();
                $video_materi = '' . $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload video: ' . $this->upload->display_errors());
                redirect('guru/add_materi');
            }
        }

        // **2️⃣ Proses Upload File Materi (PDF, Word, JPG)**
        $modul = '';
        if (!empty($_FILES['modul']['name'])) {
            $config_modul['upload_path']   = './assets/materi_modul/';
            $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
            $config_modul['max_size']      = 2048;

            $this->upload->initialize($config_modul);

            if ($this->upload->do_upload('modul')) {
                $upload_data = $this->upload->data();
                $modul = '' . $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
                redirect('guru/add_materi');
            }
        }
        $nip = $this->session->userdata('nip');

        // **3️⃣ Simpan Data ke Database**
        $data = [
            'id_guru'     => $nip,
            'nama_guru'   => htmlspecialchars($this->input->post('nama_guru', true)),
            'nama_mapel'  => htmlspecialchars($this->input->post('nama_mapel', true)),
            'video'       => $video_materi,
            'modul'       => $modul,
            'deskripsi'   => htmlspecialchars($this->input->post('deskripsi', true)),
            'linkform'    => htmlspecialchars($this->input->post('linkform', true)),
            'kelas'       => htmlspecialchars($this->input->post('kelas', true))
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
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);
        
        if ($this->form_validation->run() == false) {
            $nip = $this->session->userdata('nip'); // atau 'id_guru', sesuai yang kamu pakai
    
            // Ambil data user dari tabel guru
            $data['user'] = $this->db->get_where('guru', ['nip' => $nip])->row_array();
            $data['materi'] = $this->M_materi->get_materi_by_ids($id)->row();
            $this->load->view('guru/navug');
            $this->load->view('guru/update_materi', $data);
            $this->load->view('guru/footg');
        } else {
            // Load library upload terlebih dahulu
            $this->load->library('upload');
    
            // **1️⃣ Proses Upload Video**
            $video_materi = '';
            if (!empty($_FILES['video']['name'])) {
                $config_video['upload_path']   = './assets/materi_video/';
                $config_video['allowed_types'] = 'mp4|avi|mov|wmv|mkv|webm';
                $config_video['max_size']      = 100000;
    
                $this->upload->initialize($config_video);
    
                if ($this->upload->do_upload('video')) {
                    $upload_data = $this->upload->data();
                    $video_materi = '' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload video: ' . $this->upload->display_errors());
                    redirect('guru/add_materi');
                }
            }
            $nip = $this->session->userdata('nip');
    
            // **2️⃣ Proses Upload File Materi (PDF, Word, JPG)**
            $modul = '';
            if (!empty($_FILES['modul']['name'])) {
                $config_modul['upload_path']   = './assets/materi_modul/';
                $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
                $config_modul['max_size']      = 2048;
    
                $this->upload->initialize($config_modul);
    
                if ($this->upload->do_upload('modul')) {
                    $upload_data = $this->upload->data();
                    $modul = '' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
                    redirect('guru/add_materi');
                }
            }
            $nip = $this->session->userdata('nip');
            $guru = $this->db->get_where('guru', ['nip' => $nip])->row_array();
            // **3️⃣ Simpan Data ke Database**
            $data = [
                'nama_guru'   => htmlspecialchars($this->input->post('nama_guru', true)),
                'nama_mapel'  => htmlspecialchars($this->input->post('nama_mapel', true)),
                'video'       => $video_materi,
                'modul'       => $modul,
                'deskripsi'   => htmlspecialchars($this->input->post('deskripsi', true)),
                'linkform'    => htmlspecialchars($this->input->post('linkform', true)),
                'kelas'       => htmlspecialchars($this->input->post('kelas', true))
            ];
            $data['materi'] = $this->M_materi->tampil_materi_guru($nip)->result();
            $this->db->insert('materi', $data);
            $this->session->set_flashdata('success', 'Materi berhasil ditambahkan!');
            redirect('guru');
        }
    }
    
    public function materi_edit()
    {
        $this->load->model('m_materi');
        $id = $this->input->post('id');

        // Konfigurasi upload video
        $config['upload_path']   = './assets/materi_video/';
        $config['allowed_types'] = 'mp4|avi|mov';
        $config['max_size']      = 102400; // 100MB

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('video')) {
            $video = $this->upload->data('file_name');
        } else {
            $this->upload->display_errors();
        }

        // Konfigurasi upload modul
        $config['upload_path']   = './assets/materi_modul/';
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
        $config['max_size']      = 5120; // 5MB

        $this->upload->initialize($config);

        if ($this->upload->do_upload('modul')) {
            $modul = $this->upload->data('file_name');
        } else {
            $this->upload->display_errors();
        }// Hentikan eksekusi untuk melihat hasilnya

        
        $nip = $this->input->post('id_guru');
        $nama_guru = $this->input->post('nama_guru');
        $nama_mapel = $this->input->post('nama_mapel');
        $deskripsi = $this->input->post('deskripsi');
        $linkform = $this->input->post('linkform');
        
        $data = array(
            'id_guru' => $nip,
            'nama_guru' => $nama_guru,
            'nama_mapel' => $nama_mapel,
            'deskripsi' => $deskripsi,
            'linkform' => $linkform,
            'video'     => $video,
            'modul'     => $modul
        );

        $where = array(
            'id' => $id,
        );

        $query = $this->db->get_where('materi', array('id' => $id));

        $existing_data = $this->db->get_where('materi', array('id' => $id))->row_array();
        if ($existing_data) {
            $difference = array_diff_assoc($data, $existing_data);
            if (empty($difference)) {
                echo "❌ Tidak ada perubahan data, update dibatalkan!";
                exit;
            }
        }


        $this->m_materi->update_data($where, $data, 'materi');

        $this->m_materi->update_data($where, $data, 'materi');
     
        $this->session->set_flashdata('success-edit', 'berhasil');
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
    
}
