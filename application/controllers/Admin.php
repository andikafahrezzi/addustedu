<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
{
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('form_validation');
    $this->load->model(['M_materi', 'Forum_model', 'Quiz_model', 'Bank_soal_model', 'M_guru', "M_pertemuan"]);
    $this->load->helper('text');
    
    // Perbaikan pengecekan login
    if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'admin') {
        $this->session->set_flashdata('not-login', 'Anda harus login sebagai admin!');
        redirect(base_url('welcome/admin')); 
    }
}

    public function index()
    {
        $data['user'] = $this->db->get_where('admin', [
            'email' => $this->session->userdata('email')
        ])->row_array();

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
    $this->form_validation->set_rules('nis', 'NIS', 'required|trim|min_length[4]|is_unique[siswa.nis]', [
        'required' => 'Harap isi kolom NIS.',
        'min_length' => 'NIS terlalu pendek.',
        'is_unique' => 'NIS ini sudah terdaftar.',
    ]);

    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[guru.email]', [
        'is_unique' => 'Email ini telah digunakan!',
        'required' => 'Harap isi kolom email.',
        'valid_email' => 'Masukan email yang valid.',
    ]);

    $this->form_validation->set_rules(
        'nama',
        'Nama',
        'required|trim|min_length[4]|regex_match[/^[a-zA-Z\s]+$/]',
        [
            'required' => 'Harap isi kolom Nama.',
            'min_length' => 'Nama terlalu pendek.',
            'regex_match' => 'Nama hanya boleh berisi huruf dan spasi.',
        ]
    );

    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|matches[password2]', [
        'required' => 'Harap isi kolom Password.',
        'matches' => 'Password tidak sama!',
        'min_length' => 'Password terlalu pendek',
    ]);
    $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|trim|matches[password]', [
        'matches' => 'Password tidak sama!',
        'required' => 'Harap isi konfirmasi password.',
    ]);

    if ($this->form_validation->run() == false) {
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/add_siswa');           
        $this->load->view('admin/partials/foota');
    } else {
        $data = [
            'nis' => htmlspecialchars($this->input->post('nis', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'id_kelas' => htmlspecialchars($this->input->post('kelas', true)),
            'image' => 'default.jpg',
            'is_active' => 1,
            'date_created' => date('Y-m-d H:i:s'),
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

    $this->load->view('admin/partials/nava');
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

    $where = ['nip' => $nip];
    $data['user'] = $this->m_guru->update_guru($where, 'guru')->result();

    // Ambil semua mapel
    $data['mapel'] = $this->db->get('mata_pelajaran')->result();

    // Ambil mapel yang sedang diajar guru
    $mapel_selected = $this->db->select('id_mapel')
        ->from('guru_mapel')
        ->where('id_guru', $nip)
        ->get()
        ->result();

    // Ubah jadi array id_mapel
    $data['mapel_selected'] = array_map(function($row) {
        return $row->id_mapel;
    }, $mapel_selected);

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
    $mapel = $this->input->post('mapel'); // ambil array mapel dari form

    // Validasi dasar (jika mau kamu bisa pakai form_validation juga)
    if (!$nip || !$nama || !$email) {
        $this->session->set_flashdata('error-edit', 'Data tidak lengkap.');
        redirect('admin/data_guru');
        return;
    }

    $data = [
        'nip' => $nip,
        'nama_guru' => $nama,
        'email' => $email,
    ];

    if (!empty($new_password) && $new_password === $repeat_password) {
        $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
    }

    $where = ['nip' => $nip];

    // Update data guru di tabel guru
    $this->m_guru->update_data($where, $data, 'guru');

    // Sinkronisasi mapel di tabel guru_mapel
    $this->db->where('id_guru', $nip);
    $this->db->delete('guru_mapel'); // hapus data mapel lama

    if (!empty($mapel)) {
        foreach ($mapel as $id_mapel) {
            $this->db->insert('guru_mapel', [
                'id_guru' => $nip,
                'id_mapel' => $id_mapel
            ]);
        }
    }

    $this->session->set_flashdata('success-edit', 'Data guru berhasil diperbarui.');
    redirect('admin/data_guru');
}


    public function update_materi($id)
{
    $this->load->model('m_materi');
    $where = ['materi.id' => $id];
    $data['user'] = $this->m_materi->update_materi($where)->row(); // sudah benar

    $this->load->view('admin/partials/nava');
    $this->load->view('admin/update_materi', $data);
    $this->load->view('admin/partials/foota');
}


    public function materi_edit()
{
    $this->load->model('m_materi');
    $id = $this->input->post('id');

    // Ambil data lama
    $existing_data = $this->db->get_where('materi', ['id' => $id])->row_array();
    if (!$existing_data) {
        $this->session->set_flashdata('error', 'Data materi tidak ditemukan.');
        redirect('admin/data_materi');
    }

    // ✅ Ambil input baru dari form
    $deskripsi = $this->input->post('deskripsi');
    $linkform = $this->input->post('linkform');

    // ✅ Default pakai data lama
    $video = $existing_data['video'];
    $modul = $existing_data['modul'];

    // ✅ Upload video jika diubah
    if (!empty($_FILES['video']['name'])) {
        $config_video['upload_path']   = './assets/materi_video/';
        $config_video['allowed_types'] = 'mp4|avi|mov|wmv|mkv|webm';
        $config_video['max_size']      = 102400;

        $this->load->library('upload', $config_video);
        $this->upload->initialize($config_video);

        if ($this->upload->do_upload('video')) {
            $video = $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', 'Gagal upload video: ' . $this->upload->display_errors());
            redirect('admin/update_materi/' . $id);
        }
    }

    // ✅ Upload modul jika diubah
    if (!empty($_FILES['modul']['name'])) {
        $config_modul['upload_path']   = './assets/materi_modul/';
        $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
        $config_modul['max_size']      = 5120;

        $this->upload->initialize($config_modul);

        if ($this->upload->do_upload('modul')) {
            $modul = $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
            redirect('admin/update_materi/' . $id);
        }
    }

    // ✅ Siapkan data baru
    $data = [
        'deskripsi' => $deskripsi,
        'linkform'  => $linkform,
        'video'     => $video,
        'modul'     => $modul
    ];

    // ✅ Cek apakah ada perubahan data
    $difference = array_diff_assoc($data, $existing_data);
    unset($difference['id_guru'], $difference['id_mapel'], $difference['id_kelas']); // abaikan relasi

    if (empty($difference)) {
        $this->session->set_flashdata('warning', '❌ Tidak ada perubahan, data tidak diperbarui.');
        redirect('admin/update_materi/' . $id);
    }

    // ✅ Update database
    $this->m_materi->update_data(['id' => $id], $data, 'materi');

    $this->session->set_flashdata('success-edit', '✅ Materi berhasil diperbarui.');
    redirect('admin/data_materi');
}


public function delete_guru($nip)
{
    // Cek apakah guru punya materi
    $materi_terkait = $this->db->get_where('materi', ['id_guru' => $nip])->num_rows();

    if ($materi_terkait > 0) {
        $this->session->set_flashdata('error-delete', 'Gagal menghapus! Guru masih memiliki materi.');
    } else {
        // Hapus guru_mapel terlebih dahulu
        $this->db->where('id_guru', $nip)->delete('guru_mapel');

        // Setelah tidak ada relasi, baru hapus dari guru
        $this->db->where('nip', $nip)->delete('guru');

        $this->session->set_flashdata('success-delete', 'Guru berhasil dihapus.');
    }

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

    $this->form_validation->set_rules(
        'nama',
        'Nama',
        'required|trim|min_length[4]|regex_match[/^[a-zA-Z\s]+$/]',
        [
            'required' => 'Harap isi kolom Nama.',
            'min_length' => 'Nama terlalu pendek.',
            'regex_match' => 'Nama hanya boleh berisi huruf dan spasi.',
        ]
    );

    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|matches[password2]', [
        'required' => 'Harap isi kolom Password.',
        'matches' => 'Password tidak sama!',
        'min_length' => 'Password terlalu pendek',
    ]);

    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]', [
        'matches' => 'Password tidak sama!',
    ]);

    $this->form_validation->set_rules('mapel[]', 'Mata Pelajaran', 'required', [
        'required' => 'Pilih minimal satu mata pelajaran.',
    ]);

    if ($this->form_validation->run() == false) {
        $data['mapel'] = $this->db->get('mata_pelajaran')->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/add_guru', $data);
        $this->load->view('admin/partials/foota');
    } else {
        $nip = htmlspecialchars($this->input->post('nip', true));
        $mapel_array = $this->input->post('mapel');

        $this->db->insert('guru', [
            'nip' => $nip,
            'email' => htmlspecialchars($this->input->post('email', true)),
            'nama_guru' => htmlspecialchars($this->input->post('nama', true)),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
        ]);

        foreach ($mapel_array as $id_mapel) {
            $this->db->insert('guru_mapel', [
                'id_guru' => $nip,
                'id_mapel' => $id_mapel
            ]);
        }


        $this->session->set_flashdata('success-reg', 'Berhasil menambahkan guru!');
        redirect(base_url('admin/data_guru'));
    }
}

public function get_mapel_by_guru($nip)
{
    $this->db->select('mata_pelajaran.id, mata_pelajaran.nama_mapel');
    $this->db->from('guru_mapel');
    $this->db->join('mata_pelajaran', 'guru_mapel.id_mapel = mata_pelajaran.id');
    $this->db->where('guru_mapel.id_guru', $nip);
    $query = $this->db->get()->result();

    echo json_encode($query);
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

    $this->form_validation->set_rules('id_mapel', 'Mata Pelajaran', 'required');
    $this->form_validation->set_rules('id_guru', 'Guru', 'required');
    $this->form_validation->set_rules('id_kelas', 'Kelas', 'required');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
    $this->form_validation->set_rules('linkform', 'Link Google Form', 'required');

    if ($this->form_validation->run() == false) {
        $data['guru'] = $this->M_guru->tampil_data()->result();
        $data['kelas'] = $this->db->get('kelas')->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/add_materi', $data);
        $this->load->view('admin/partials/foota');
    } else {
        $this->load->library('upload');

        // Upload video
        $video_materi = '';
        if (!empty($_FILES['video']['name'])) {
            $config_video['upload_path'] = './assets/materi_video/';
            $config_video['allowed_types'] = 'mp4|avi|mov|wmv|mkv|webm';
            $config_video['max_size'] = 100000;

            $this->upload->initialize($config_video);
            if ($this->upload->do_upload('video')) {
                $upload_data = $this->upload->data();
                $video_materi = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload video: ' . $this->upload->display_errors());
                redirect('admin/add_materi');
            }
        }

        // Upload modul
        $modul = '';
        if (!empty($_FILES['modul']['name'])) {
            $config_modul['upload_path'] = './assets/materi_modul/';
            $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
            $config_modul['max_size'] = 2048;

            $this->upload->initialize($config_modul);
            if ($this->upload->do_upload('modul')) {
                $upload_data = $this->upload->data();
                $modul = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
                redirect('admin/add_materi');
            }
        }

        $data = [
            'id_guru'   => $this->input->post('id_guru', true),
            'id_mapel'  => $this->input->post('id_mapel', true),
            'id_kelas'  => $this->input->post('id_kelas', true),
            'video'     => $video_materi,
            'modul'     => $modul,
            'deskripsi' => htmlspecialchars($this->input->post('deskripsi', true)),
            'linkform'  => htmlspecialchars($this->input->post('linkform', true))
        ];

        $insert = $this->db->insert('materi', $data);

        if ($insert) {
            $this->session->set_flashdata('success', 'Materi berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data materi!');
        }

        redirect(base_url('admin/data_materi'));
    }
}

    public function hapus_forum($materi_id) {
        $this->load->model('Forum_model');
        
        // Cek apakah forum ada
        $forum = $this->Forum_model->get_forum_by_materi($materi_id);
        if(empty($forum)) {
            $this->session->set_flashdata('error', 'Forum tidak ditemukan');
            redirect('admin/data_fordis');
        }
    
        // Proses penghapusan
        if($this->Forum_model->hapus_forum_by_materi($materi_id)) {
            $this->session->set_flashdata('success', 'Forum diskusi berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus forum');
        }
        redirect('admin/data_fordis');
    }
    public function data_fordis() {
        // Cek role admin
    
        $this->load->model('M_materi');
        $data['materi'] = $this->M_materi->get_all_materi();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_fordis', $data);
        $this->load->view('admin/partials/foota');
    }

    public function add_quiz()
{
    $this->load->model('Quiz_model');
    
    // Validasi form
    $this->form_validation->set_rules('id_pertemuan', 'Materi', 'required');
    $this->form_validation->set_rules('judul', 'Judul Quiz', 'required|max_length[100]');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[500]');
    $this->form_validation->set_rules('waktu_pengerjaan', 'Waktu Pengerjaan', 'required|numeric');
    $this->form_validation->set_rules('attempts', 'Percobaan Maksimal', 'required|numeric');
    
    if ($this->form_validation->run()) {
        $quiz_data = [
            'id_pertemuan' => $this->input->post('id_pertemuan'),
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
    
    
    $this->load->view('admin/add_quiz', $data);
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
    
    // BANK SOAL - ADMIN
    public function bank_soal() {
        $data['title'] = 'Bank Soal';
        $data['soal'] = $this->Bank_soal_model->get_all_soal()->result();
        
        $this->load->view('admin/partials/nava', $data);
        $this->load->view('admin/data_bank_soal', $data);
        $this->load->view('admin/partials/foota');
    }

    public function add_bank_soal() {
        $data['title'] = 'Tambah Soal';
        
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required');
        $this->form_validation->set_rules('tipe_soal', 'Tipe Soal', 'required|in_list[pilihan,essay]');
        $this->form_validation->set_rules('mapel', 'Mata Pelajaran', 'required');
        
        // Validasi khusus untuk pilihan ganda
        if ($this->input->post('tipe_soal') == 'pilihan') {
            $this->form_validation->set_rules('pilihan_a', 'Pilihan A', 'required');
            $this->form_validation->set_rules('pilihan_b', 'Pilihan B', 'required');
            $this->form_validation->set_rules('pilihan_c', 'Pilihan C', 'required');
            $this->form_validation->set_rules('pilihan_d', 'Pilihan D', 'required');
            $this->form_validation->set_rules('kunci_jawaban', 'Kunci Jawaban', 'required|in_list[a,b,c,d]');
        }
        
        if ($this->form_validation->run() === FALSE) {
            $data['mapel'] = $this->db->get('mata_pelajaran')->result();
            $this->load->view('admin/add_bank_soal', $data);
            $this->load->view('admin/partials/foota');
        } else {
            $post_data = $this->input->post();
            $data = [
                'pertanyaan' => $post_data['pertanyaan'],
                'tipe_soal' => $post_data['tipe_soal'],
                'tingkat_kesulitan' => $post_data['tingkat_kesulitan'] ?? 'sedang',
                'tipe_kognitif' => $post_data['tipe_kognitif'] ?? 'paham',
                'created_by' => $this->session->userdata('id'),
                'user_type' => 'admin',
                'id_mapel' => $post_data['mapel'],
                'created_at' => date('Y-m-d H:i:s')
            ];
    
            // Tambahkan data khusus pilihan ganda jika diperlukan
            if ($post_data['tipe_soal'] == 'pilihan') {
                $data['pilihan_a'] = $post_data['pilihan_a'];
                $data['pilihan_b'] = $post_data['pilihan_b'];
                $data['pilihan_c'] = $post_data['pilihan_c'];
                $data['pilihan_d'] = $post_data['pilihan_d'];
                $data['kunci_jawaban'] = $post_data['kunci_jawaban'];
            }
    
            if ($this->Bank_soal_model->tambah_soal($data)) {
                $this->session->set_flashdata('success', 'Soal berhasil ditambahkan');
            } else {
                $error = $this->db->error();
                $this->session->set_flashdata('error', 'Gagal menyimpan: '.$error['message']);
            }
            redirect('admin/bank_soal');
        }
    }

    public function edit_bank_soal($id_soal) {
        $data['title'] = 'Edit Soal';
        $data['soal'] = $this->Bank_soal_model->get_detail_soal($id_soal);
        
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required');
        $this->form_validation->set_rules('tipe_soal', 'Tipe Soal', 'required|in_list[pilihan,essay]');
        $this->form_validation->set_rules('mapel_diajarkan', 'Mata Pelajaran', 'required');
        
        // Validasi khusus untuk pilihan ganda
        if ($this->input->post('tipe_soal') == 'pilihan') {
            $this->form_validation->set_rules('pilihan_a', 'Pilihan A', 'required');
            $this->form_validation->set_rules('pilihan_b', 'Pilihan B', 'required');
            $this->form_validation->set_rules('pilihan_c', 'Pilihan C', 'required');
            $this->form_validation->set_rules('pilihan_d', 'Pilihan D', 'required');
            $this->form_validation->set_rules('kunci_jawaban', 'Kunci Jawaban', 'required|in_list[a,b,c,d]');
        }
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/update_bank_soal', $data);
            $this->load->view('admin/partials/foota');
        } else {
            $post_data = $this->input->post();
            $update_data = [
                'pertanyaan' => $post_data['pertanyaan'],
                'tipe_soal' => $post_data['tipe_soal'],
                'tingkat_kesulitan' => $post_data['tingkat_kesulitan'],
                'tipe_kognitif' => $post_data['tipe_kognitif'],
                'mapel_diajarkan' => $post_data['mapel_diajarkan'],
            ];
    
            // Tambahkan data khusus pilihan ganda jika diperlukan
            if ($post_data['tipe_soal'] == 'pilihan') {
                $update_data['pilihan_a'] = $post_data['pilihan_a'];
                $update_data['pilihan_b'] = $post_data['pilihan_b'];
                $update_data['pilihan_c'] = $post_data['pilihan_c'];
                $update_data['pilihan_d'] = $post_data['pilihan_d'];
                $update_data['kunci_jawaban'] = $post_data['kunci_jawaban'];
            } else {
                // Kosongkan data pilihan jika diubah ke essay
                $update_data['pilihan_a'] = null;
                $update_data['pilihan_b'] = null;
                $update_data['pilihan_c'] = null;
                $update_data['pilihan_d'] = null;
                $update_data['kunci_jawaban'] = null;
            }
    
            if ($this->Bank_soal_model->update_soal($id_soal, $update_data)) {
                $this->session->set_flashdata('success', 'Soal berhasil diperbarui');
            } else {
                $error = $this->db->error();
                $this->session->set_flashdata('error', 'Gagal memperbarui: '.$error['message']);
            }
            redirect('admin/bank_soal');
        }
    }

    public function hapus_soal($id_soal) {
        $this->Bank_soal_model->hapus_soal($id_soal);
        $this->session->set_flashdata('success', 'Soal berhasil dihapus');
        redirect('admin/bank_soal');
    }
    public function data_ujian()
    {
        $this->load->model('Ujian_model');

        $data['user'] = $this->db->get_where('admin', ['email' =>
            $this->session->userdata('email')])->row_array();

        $data['user'] = $this->Ujian_model->tampil_ujian()->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_ujian', $data);
        $this->load->view('admin/partials/foota');

    }
    public function detail_ujian($id_ujian)
    {
        $this->load->model('Ujian_model');
        $where = array('id_ujian' => $id_ujian);
        $detail = $this->Ujian_model->detail_ujian($id_ujian);
        $data['detail'] = $detail;
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/detail_ujian', $data);
        $this->load->view('admin/partials/foota');
    }
    public function form_pertemuan()
{
    $nip = $this->session->userdata('nip');

    $this->load->model('M_pertemuan');
    $data['guru'] = $this->M_guru->tampil_data()->result();
    $data['materi'] = $this->M_pertemuan->get_materi_by_guru($nip);
    $data['kelas']  = $this->M_pertemuan->get_all_kelas();

    // $this->load->view('admin/partials/nava');
    $this->load->view('admin/add_pertemuan', $data);
    $this->load->view('admin/partials/foota');
}

public function add_pertemuan()
{
    $this->form_validation->set_rules('id_materi', 'Materi', 'required');
    $this->form_validation->set_rules('id_kelas', 'Kelas', 'required');
    $this->form_validation->set_rules('pertemuan_ke', 'Pertemuan Ke', 'required|integer');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->form_pertemuan();
    } else {
        $data = [
            'id_materi'     => $this->input->post('id_materi'),
            'id_kelas'      => $this->input->post('id_kelas'),
            'pertemuan_ke'  => $this->input->post('pertemuan_ke'),
            'tanggal'       => $this->input->post('tanggal')
        ];

        $this->load->model('M_pertemuan');
        $this->M_pertemuan->insert_pertemuan($data);

        $this->session->set_flashdata('success', 'Pertemuan berhasil ditambahkan.');
        redirect('admin/form_pertemuan');
    }
}
    public function get_materi_by_guru($nip)
{
    $this->db->select('materi.id, materi.deskripsi, mata_pelajaran.nama_mapel');
    $this->db->from('materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->where('materi.id_guru', $nip);
    $query = $this->db->get()->result();

    echo json_encode($query);
}


}
