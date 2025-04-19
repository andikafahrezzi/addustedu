<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);
        $this->session->set_flashdata('not-login', 'Gagal!');
        if (!$this->session->userdata('email')) {
            redirect('welcome/admin');
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('admin', ['email' =>
            $this->session->userdata('email')])->row_array();

        $this->load->view('admin/partials/nava');
        $this->load->view('admin/index');
        $this->load->view('admin/partials/foota');
    }

    public function about_developer()
    {
        $data['user'] = $this->db->get_where('admin', ['email' =>
            $this->session->userdata('email')])->row_array();

            $this->load->view('admin/partials/nava');
            $this->load->view('admin/about_developer');
            $this->load->view('admin/partials/foota');
    }

    public function about_addustedu()
    {
        $data['user'] = $this->db->get_where('admin', ['email' =>
            $this->session->userdata('email')])->row_array();
        
            $this->load->view('admin/partials/nava');
            $this->load->view('admin/about_addustedu');
            $this->load->view('admin/partials/foota');
    }

    // Management Siswa

    public function data_siswa()
    {
        $this->load->model('m_siswa');

        $data['user'] = $this->db->get_where('admin', ['email' =>
            $this->session->userdata('email')])->row_array();

        $data['user'] = $this->m_siswa->tampil_data()->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_siswa', $data);
        $this->load->view('admin/partials/foota');
    }

    public function detail_siswa($id)
    {
        $this->load->model('m_siswa');
        $where = array('id' => $id);
        $detail = $this->m_siswa->detail_siswa($id);
        $data['detail'] = $detail;
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/detail_siswa', $data);
        $this->load->view('admin/partials/foota');
    }
    public function add_siswa()
    {
        $this->form_validation->set_rules('nip', 'Nip', 'required|trim|min_length[4]', [
            'required' => 'Harap isi kolom NIP.',
            'min_length' => 'NIP terlalu pendek.',
        ]);

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[guru.email]', [
            'is_unique' => 'Email ini telah digunakan!',
            'required' => 'Harap isi kolom email.',
            'valid_email' => 'Masukan email yang valid.',
        ]);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|min_length[4]', [
            'required' => 'Harap isi kolom nAMA.',
            'min_length' => 'Nama terlalu pendek.',
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'required' => 'Harap isi kolom Password.',
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password terlalu pendek',
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]', [
            'matches' => 'Password tidak sama!',
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/add_siswa');           
            $this->load->view('admin/partials/foota');
        } else {
            $data = [
                'nis' => htmlspecialchars($this->input->post('nis', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'nama_guru' => htmlspecialchars($this->input->post('nama', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nama_mapel' => htmlspecialchars($this->input->post('mapel', true)),
            ];

            $this->db->insert('siswa', $data);

            $this->session->set_flashdata('success-reg', 'Berhasil!');
            redirect(base_url('admin/data_siswa'));
        }
    }

    public function update_siswa($nis)
    {
        $this->load->model('m_siswa');
        $where = array('nis' => $nis);
        $data['user'] = $this->m_siswa->update_siswa($where, 'siswa')->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/update_siswa', $data);
        $this->load->view('admin/partials/foota');
    }
    

    public function user_edit()
{
    $this->load->model('m_siswa');

    $nis = $this->input->post('nis');
    $nama = $this->input->post('nama');
    $email = $this->input->post('email');
    $gambar = $_FILES['image']['name'];

    // Ambil data password baru
    $new_password = $this->input->post('nPassword');
    $repeat_password = $this->input->post('nRPassword');

    $nis_lama = $this->input->post('nis_lama'); // untuk where
    $nis_baru = $this->input->post('nis'); // untuk data update
    $where = array('nis' => $nis_lama);

$data = array(
    'nis' => $nis_baru,
    'nama' => $nama,
    'email' => $email,
);

    // Update password jika diisi dan cocok
    if (!empty($new_password) && $new_password === $repeat_password) {
        $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
    }

    // Proses upload foto
    $config['allowed_types'] = 'jpg|png|gif|jfif';
    $config['max_size'] = '4096';
    $config['upload_path'] = './assets/profile_picture';

    $this->load->library('upload', $config);
    if ($this->upload->do_upload('image')) {
        $gambarBaru = $this->upload->data('file_name');
        $data['image'] = $gambarBaru;
    }

    $this->m_siswa->update_data($where, $data, 'siswa');

    $this->load->view('admin/nava');
    $this->session->set_flashdata('success-edit', 'Berhasil memperbarui data siswa');
    redirect('admin/data_siswa');
}


    public function delete_siswa($id)
    {
        $this->load->model('m_siswa');
        $where = array('nis' => $id);
        $this->m_siswa->delete_siswa($where, 'siswa');
        $this->session->set_flashdata('user-delete', 'berhasil');
        redirect('admin/data_siswa');
    }

    // manajemen guru

    public function data_guru()
    {
        $this->load->model('m_guru');
        $data['user'] = $this->db->get_where('admin', ['email' =>
            $this->session->userdata('email')])->row_array();

        $data['user'] = $this->m_guru->tampil_data()->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_guru', $data);
        $this->load->view('admin/partials/foota');
    }

    public function detail_guru($nip)
    {
        $this->load->model('m_guru');
        $where = array('nip' => $nip);
        $detail = $this->m_guru->detail_guru($nip);
        $data['detail'] = $detail;
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/detail_guru', $data);
        $this->load->view('admin/partials/foota');
    }

    public function update_guru($nip)
    {
        $this->load->model('m_guru');
        $where = array('nip' => $nip);
        $data['user'] = $this->m_guru->update_guru($where, 'guru')->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/update_guru', $data);
        $this->load->view('admin/partials/foota');
    }

    public function guru_edit()
    {
        $this->load->model('m_guru');
        $nip = $this->input->post('nip');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $new_password = $this->input->post('nPassword');
        $repeat_password = $this->input->post('nRPassword');
    
        
        $data = array(
            'nip' => $nip,
            'nama_guru' => $nama,
            'email' => $email,

        );
        if (!empty($new_password) && $new_password === $repeat_password) {
            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $where = array(
            'nip' => $nip,
        );


        $this->m_guru->update_data($where, $data, 'guru');
        $this->session->set_flashdata('success-edit', 'berhasil');
        redirect('admin/data_guru');
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/partials/foota');
    }

    public function update_materi($id)
    {
        $this->load->model('m_materi');
        $where = array('id' => $id);
        $data['user'] = $this->m_materi->update_materi($where, 'materi')->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/update_materi', $data);
        $this->load->view('admin/partials/foota');
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


        $nama_guru = $this->input->post('nama_guru');
        $nama_mapel = $this->input->post('nama_mapel');
        $deskripsi = $this->input->post('deskripsi');
        $linkform = $this->input->post('linkform');
        
        $data = array(
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
        redirect('admin/data_materi');
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/partials/foota');
    }

    public function delete_guru($nip)
    {
        $this->load->model('m_guru');
        $where = array('nip' => $nip);
        $this->m_guru->delete_guru($where, 'guru');
        $this->session->set_flashdata('user-delete', 'berhasil');
        redirect('admin/data_guru');
    }

    public function add_guru()
    {
        $this->form_validation->set_rules('nip', 'Nip', 'required|trim|min_length[4]', [
            'required' => 'Harap isi kolom NIP.',
            'min_length' => 'NIP terlalu pendek.',
        ]);

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[guru.email]', [
            'is_unique' => 'Email ini telah digunakan!',
            'required' => 'Harap isi kolom email.',
            'valid_email' => 'Masukan email yang valid.',
        ]);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|min_length[4]', [
            'required' => 'Harap isi kolom nAMA.',
            'min_length' => 'Nama terlalu pendek.',
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'required' => 'Harap isi kolom Password.',
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password terlalu pendek',
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]', [
            'matches' => 'Password tidak sama!',
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/partials/nava');
            $this->load->view('admin/add_guru');
            $this->load->view('admin/partials/foota');

        } else {
            $data = [
                'nip' => htmlspecialchars($this->input->post('nip', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'nama_guru' => htmlspecialchars($this->input->post('nama', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nama_mapel' => htmlspecialchars($this->input->post('mapel', true)),
            ];

            $this->db->insert('guru', $data);

            $this->session->set_flashdata('success-reg', 'Berhasil!');
            redirect(base_url('admin/data_guru'));
            $this->load->view('admin/nava');
        }
    }

    //manajemen materi

    public function data_materi()
    {
        $this->load->model('m_materi');

        $data['user'] = $this->db->get_where('admin', ['email' =>
            $this->session->userdata('email')])->row_array();

        $data['user'] = $this->m_materi->tampil_data()->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_materi', $data);
        $this->load->view('admin/partials/foota');
    }

    public function delete_materi($id)
    {
        $this->load->model('m_materi');
        $where = array('id' => $id);
        $this->m_materi->delete_materi($where, 'materi');
        $this->session->set_flashdata('user-delete', 'berhasil');
        redirect('admin/data_materi');
    }

    public function add_materi()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required');
        
        if ($this->form_validation->run() == false) {
            $data['guru'] = $this->db->get('guru')->result();
            $this->load->view('admin/partials/nava');
            $this->load->view('admin/add_materi', $data);
            $this->load->view('admin/partials/foota');
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
                    redirect('admin/add_materi');
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
                    redirect('admin/add_materi');
                }
            }
            $nip = $this->input->post('guru_info', true); // dari <select>
            $nama_guru = $this->input->post('nama_guru', true);
            $nip = $this->input->post('guru_info', true);
$nama_guru = $this->input->post('nama_guru', true);

if (!$nama_guru) {
    die('Nama guru kosong! Pastikan JS berjalan dan field terisi.');
}
 // dari <input readonly>
            


    
            // **3️⃣ Simpan Data ke Database**
            $data = [
                'id_guru'     => $nip,
                'nama_guru'   => $nama_guru,
                'nama_mapel'  => htmlspecialchars($this->input->post('nama_mapel', true)),
                'video'       => $video_materi,
                'modul'       => $modul,
                'deskripsi'   => htmlspecialchars($this->input->post('deskripsi', true)),
                'linkform'    => htmlspecialchars($this->input->post('linkform', true)),
                'kelas'       => htmlspecialchars($this->input->post('kelas', true))
            ];
    
            $this->db->insert('materi', $data);
            $this->session->set_flashdata('success', 'Materi berhasil ditambahkan!');
            redirect(base_url('admin/data_materi'));
        }
    }

    public function hapus_forum($materi_id) {
        $this->load->model('Forum_model');
        
        // Cek apakah forum ada
        $forum = $this->Forum_model->get_forum_by_materi($materi_id);
        if(empty($forum)) {
            $this->session->set_flashdata('error', 'Forum tidak ditemukan');
            redirect('admin/list_materi');
        }
    
        // Proses penghapusan
        if($this->Forum_model->hapus_forum_by_materi($materi_id)) {
            $this->session->set_flashdata('success', 'Forum diskusi berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus forum');
        }
        redirect('admin/list_materi');
    }
    public function list_materi() {
        // Cek role admin
    
        $this->load->model('M_materi');
        $data['materi'] = $this->M_materi->get_all_materi();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/list_materi', $data);
        $this->load->view('admin/partials/foota');
    }

    public function buat_quiz()
{
    $this->load->model('Quiz_model');
    
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
        redirect('admin/kelola_quiz/'.$quiz_id);
    }
    
    $data['materi_list'] = $this->Quiz_model->get_materi_list();
    
    
    $this->load->view('admin/buat_quiz', $data);
    $this->load->view('admin/partials/foota');
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
    
    
    
    $this->load->view('admin/kelola_quiz', $data);
    $this->load->view('admin/partials/foota');
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
public function data_quiz()
    {
        $this->load->model('Quiz_model');

        $data['user'] = $this->db->get_where('admin', ['email' =>
            $this->session->userdata('email')])->row_array();

        $data['user'] = $this->Quiz_model->tampil_quiz()->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_quiz', $data);
        $this->load->view('admin/partials/foota');
    }
    public function delete_quiz($id) {
        // Validasi ID
        if(empty($id) || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID Quiz tidak valid');
            redirect('admin/data_quiz');
        }
        
        $result = $this->Quiz_model->delete_quiz($id);
        
        if($result) {
            $this->session->set_flashdata('success', 'Quiz dan semua data terkait berhasil dihapus');
        } else {
            $error = $this->db->error();
            $this->session->set_flashdata('error', 'Gagal menghapus quiz: '.$error['message']);
        }
        
        redirect('admin/data_quiz');
    }
}
