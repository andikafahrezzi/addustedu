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
    $this->load->library('pagination');

    // admin login
    $data['admin'] = $this->db->get_where('admin', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    // Handle search parameters - FIXED VERSION
    $filters = [];
    
    // Jika ada parameter GET dari form search
    if ($this->input->get('submit')) {
        $filters = [
            'keyword' => $this->input->get('keyword'),
            'kelas'   => $this->input->get('kelas'),
        ];
        $this->session->set_userdata('filters_siswa', $filters);
    }
    // Jika ada parameter GET langsung (bisa dari pagination)
    elseif ($this->input->get('keyword') !== null || $this->input->get('kelas') !== null) {
        $filters = [
            'keyword' => $this->input->get('keyword'),
            'kelas'   => $this->input->get('kelas'),
        ];
    }
    // Jika tidak ada parameter GET, coba ambil dari session
    else {
        $filters = $this->session->userdata('filters_siswa') ?? [];
    }

    // pagination config - KONFIGURASI YANG BENAR
    $config['base_url']   = site_url('admin/data_siswa');
    $config['total_rows'] = $this->m_siswa->count_all($filters);
    $config['per_page']   = 10;
    $config['uri_segment'] = 3;
    $config['reuse_query_string'] = TRUE; // YANG PALING PENTING
    
    $this->pagination->initialize($config);

    $page = $this->uri->segment(3, 0);

    // ambil data siswa
    $data['siswa'] = $this->m_siswa->get_paginated($config['per_page'], $page, $filters);
    $data['pagination'] = $this->pagination->create_links();

    // filters dan kelas
    $data['filters'] = $filters;
    $data['kelas_list'] = $this->db->get('kelas')->result();

    $this->load->view('admin/partials/nava', $data);
    $this->load->view('admin/data_siswa', $data);
    $this->load->view('admin/partials/foota');
}

public function reset_search()
{
    $this->session->unset_userdata('filters_siswa');
    redirect('admin/data_siswa');
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
        $data['kelas'] = $this->db->get('kelas')->result();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/add_siswa', $data);           
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
    $nis_lama = $this->input->post('nis_lama'); // untuk where
    $nis_baru = $this->input->post('nis');     // untuk data update

    // Form validation
    $this->form_validation->set_rules(
        'nama',
        'Nama',
        'required|trim|min_length[4]|callback_valid_nama',
        [
            'required' => 'Harap isi kolom Nama.',
            'min_length' => 'Nama terlalu pendek.',
        ]
    );

    $this->form_validation->set_rules(
        'nPassword',
        'Password Baru',
        'trim|min_length[8]|matches[nRPassword]',
        [
            'matches' => 'Password baru dan konfirmasi tidak sama!',
            'min_length' => 'Password terlalu pendek',
        ]
    );

    $this->form_validation->set_rules(
        'nRPassword',
        'Konfirmasi Password',
        'trim|matches[nPassword]',
        [
            'matches' => 'Password baru dan konfirmasi tidak sama!',
        ]
    );

    if ($this->form_validation->run() == false) {
        $data['user'] = $this->db->get_where('siswa', ['nis' => $nis_lama])->result();
        $data['errors'] = validation_errors();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/update_siswa', $data);
        $this->load->view('admin/partials/foota');
        return;
    }

    // Ambil input
    $nama  = htmlspecialchars($this->input->post('nama', true));
    $email = htmlspecialchars($this->input->post('email', true));
    $new_password = $this->input->post('nPassword');
    $repeat_password = $this->input->post('nRPassword');
    $gambar = $_FILES['image']['name'];

    $where = ['nis' => $nis_lama];

    // Data untuk update
    $data = [
        'nis'   => $nis_baru,
        'nama'  => $nama,
        'email' => $email,
    ];

    // Update password jika diisi dan cocok
    if (!empty($new_password) && $new_password === $repeat_password) {
        $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
    }

    // Upload foto jika ada
    if (!empty($gambar)) {
        $config['upload_path']   = './assets/profile_picture';
        $config['allowed_types'] = 'jpg|png|gif|jfif';
        $config['max_size']      = 4096;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $gambarBaru = $this->upload->data('file_name');
            $data['image'] = $gambarBaru;
        } else {
            $data['upload_error'] = $this->upload->display_errors();
            $data['user'] = $this->db->get_where('siswa', ['nis' => $nis_lama])->result();
            $this->load->view('admin/partials/nava');
            $this->load->view('admin/user_edit', $data);
            $this->load->view('admin/partials/foota');
            return;
        }
    }

    $this->m_siswa->update_data($where, $data, 'siswa');
    $this->session->set_flashdata('success-edit', 'Berhasil memperbarui data siswa');
    redirect('admin/data_siswa');
}

/**
 * Callback validasi nama (hanya huruf dan spasi)
 */
public function valid_nama($str)
{
    if (!preg_match("/^[a-zA-Z\s]+$/", $str)) {
        $this->form_validation->set_message('valid_nama', 'Nama hanya boleh berisi huruf dan spasi.');
        return false;
    }
    return true;
}

public function delete_siswa($id)
{
    $this->load->model('M_siswa');

    // Cek apakah siswa digunakan di tabel lain
    $dipakai = false;

    // Cek di tbl_jawaban_siswa
    $jawaban = $this->db->get_where('tbl_jawaban_siswa', ['nis' => $id])->num_rows();
    if ($jawaban > 0) $dipakai = true;

    // Cek di tbl_nilai (jika kamu punya)
    $tugas = $this->db->get_where('tugas_siswa', ['siswa_id' => $id])->num_rows();
    if ($tugas > 0) $dipakai = true;
    $quizs = $this->db->get_where('quiz_siswa', ['siswa_id' => $id])->num_rows();
    if ($quizs > 0) $dipakai = true;
    $fordis = $this->db->get_where('forum_diskusi', ['user_id' => $id])->num_rows();
    if ($fordis > 0) $dipakai = true;
    
    // Cek di tabel lain (tambah di sini jika ada)

    if ($dipakai) {
        $this->session->set_flashdata('error', 'Siswa tidak dapat dihapus karena masih digunakan di data lain.');
    } else {
        $where = ['nis' => $id];
        $this->M_siswa->delete_siswa($where, 'siswa');
        $this->session->set_flashdata('success', 'Siswa berhasil dihapus.');
    }

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
    if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'admin') {
        redirect('welcome');
    }

    $this->load->model('m_guru');

    $guru = $this->m_guru->get_guru_by_nip($nip);
    if (!$guru) {
        $this->session->set_flashdata('error', 'Data guru tidak ditemukan');
        redirect('admin/data_guru');
    }
    $data['user'] = $guru;

    $data['user'] = $guru;

    // Ambil semua mapel
    $data['mapel'] = $this->db->get('mata_pelajaran')->result();

    // Ambil mapel yang sedang diajar guru
    $mapel_selected = $this->db->select('id_mapel')
        ->from('guru_mapel')
        ->where('id_guru', $nip)
        ->get()
        ->result();

    $data['mapel_selected'] = array_map(function($row) {
        return $row->id_mapel;
    }, $mapel_selected);

    $this->load->view('admin/partials/nava');
    $this->load->view('admin/update_guru', $data);
    $this->load->view('admin/partials/foota');
}

public function guru_edit()
{
    if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'admin') {
        redirect('welcome');
    }

    $this->load->model('M_guru');
    $this->load->library('form_validation');

    // Validasi
    $this->form_validation->set_rules('nip', 'NIP', 'required|numeric');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('nPassword', 'Password Baru', 'min_length[6]');
    $this->form_validation->set_rules('nRPassword', 'Ulangi Password', 'matches[nPassword]');
    $this->form_validation->set_rules(
    'nama',
    'Nama Guru',
    'required|trim|min_length[4]|callback_valid_nama',
    [
        'required' => 'Harap isi kolom Nama.',
        'min_length' => 'Nama terlalu pendek.',
    ]
    );
    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error-edit', validation_errors());
        redirect('admin/update_guru/'.$this->input->post('nip')); 
        return;
    }

    $nip = $this->input->post('nip');
    $nama = $this->input->post('nama');
    $email = $this->input->post('email');
    $new_password = $this->input->post('nPassword');
    $repeat_password = $this->input->post('nRPassword');
    $mapel = $this->input->post('mapel'); // <-- array dari checkbox

    // Validasi guru
    $guru_exists = $this->M_guru->get_guru_by_nip($nip);
    if (!$guru_exists) {
        $this->session->set_flashdata('error-edit', 'Data guru tidak ditemukan');
        redirect('admin/data_guru');
        return;
    }

    // Data update
    $data = [
        'nama_guru' => htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'),
        'email'     => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
    ];

    // Kalau ada password baru
    if (!empty($new_password)) {
        if ($new_password !== $repeat_password) {
            $this->session->set_flashdata('error-edit', 'Password dan ulangi password tidak sama');
            redirect('admin/update_guru/'.$nip); // ✅ balik ke form update guru
            return;
        }
        $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
    }

    $where = ['nip' => $nip];

    // Update data guru
    $this->M_guru->update_data($where, $data, 'guru');

    // Sinkronisasi mapel
    $this->db->where('id_guru', $nip);
    $this->db->delete('guru_mapel');

    if (!empty($mapel)) {
        foreach ($mapel as $id_mapel) {
            $this->db->insert('guru_mapel', [
                'id_guru'  => $nip,
                'id_mapel' => (int)$id_mapel
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

    // Ambil input baru
    $deskripsi   = $this->input->post('deskripsi', true);
    $linkform    = $this->input->post('linkform', true);
    $video_input = $this->input->post('videourl', true);

    // Default: pakai data lama
    $video_embed = $existing_data['video'];
    $modul       = $existing_data['modul'];

    // ✅ Handle video baru (jika berbeda dengan lama)
    if (!empty($video_input) && $video_input !== $existing_data['video']) {
        if (!$this->_validate_video_url($video_input)) {
            $this->session->set_flashdata('error', 'URL video tidak valid. Hanya YouTube/Vimeo/Google Drive yang didukung');
            redirect('admin/update_materi/' . $id);
            return;
        }

        $converted = $this->_convert_video_to_embed($video_input);
        if ($converted === false) {
            $this->session->set_flashdata('error', 'Gagal mengkonversi URL video.');
            redirect('admin/update_materi/' . $id);
            return;
        }
        $video_embed = $converted;
    }

    // ✅ Upload modul baru (jika ada file baru)
    if (!empty($_FILES['modul']['name'])) {
        $config_modul['upload_path']   = './assets/materi_modul/';
        $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
        $config_modul['max_size']      = 5120;

        $this->upload->initialize($config_modul);

        if ($this->upload->do_upload('modul')) {
            $modul = $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', 'Gagal upload file materi: ' . strip_tags($this->upload->display_errors()));
            redirect('admin/update_materi/' . $id);
            return;
        }
    }

    // ✅ Siapkan data baru
    $data = [
        'deskripsi' => $deskripsi,
        'linkform'  => $linkform,
        'video'     => $video_embed,
        'modul'     => $modul
    ];

    // ✅ Cek apakah ada perubahan dibanding data lama
    $changes = [];
    foreach ($data as $key => $value) {
        if ($value != $existing_data[$key]) {
            $changes[$key] = $value;
        }
    }

    if (empty($changes)) {
        $this->session->set_flashdata('warning', '❌ Tidak ada perubahan, data tidak diperbarui.');
        redirect('admin/update_materi/' . $id);
    }

    // ✅ Update database hanya dengan field yang berubah
    $this->m_materi->update_data(['id' => $id], $changes, 'materi');

    $this->session->set_flashdata('success-edit', '✅ Materi berhasil diperbarui.');
    redirect('admin/data_materi');
}


/**
 * Validates video URL (reusable for add_materi)
 */
private function _validate_video_url($url) {
    if (empty($url)) return true;

    $allowed_domains = [
        'youtube.com',
        'youtu.be',
        'vimeo.com',
        'drive.google.com'
    ];

    // Basic URL structure check
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    // Extract domain
    $parsed = parse_url($url);
    $host = $parsed['host'] ?? '';

    // Check against whitelist
    foreach ($allowed_domains as $domain) {
        if (strpos($host, $domain) !== false) {
            return true;
        }
    }

    return false;
}

/**
 * Converts video URL to embed format (reusable for add_materi)
 */
private function _convert_video_to_embed($url) {
    $parsed = parse_url($url);
    $host = $parsed['host'] ?? '';

    // YouTube
    if (strpos($host, 'youtube.com') !== false || strpos($host, 'youtu.be') !== false) {
        if (strpos($host, 'youtu.be') !== false) {
            $video_id = substr($parsed['path'], 1);
        } else {
            parse_str($parsed['query'] ?? '', $query);
            $video_id = $query['v'] ?? '';
        }
        return $video_id ? 'https://www.youtube.com/embed/'.$video_id.'?rel=0' : false;
    }

    // Vimeo
    if (strpos($host, 'vimeo.com') !== false) {
        $video_id = substr($parsed['path'], 1);
        return is_numeric($video_id) ? 'https://player.vimeo.com/video/'.$video_id : false;
    }

    // Google Drive
    if (strpos($host, 'drive.google.com') !== false) {
        preg_match('/\/file\/d\/([^\/]+)/', $url, $matches);
        return isset($matches[1]) ? 'https://drive.google.com/file/d/'.$matches[1].'/preview' : false;
    }

    return false;
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
    
    $this->form_validation->set_rules('nip', 'NIP', 'required|trim|min_length[4]|is_unique[guru.nip]', [
    'required' => 'Harap isi kolom NIP.',
    'min_length' => 'NIP terlalu pendek.',
    'is_unique' => 'NIP ini sudah terdaftar!'
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
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'image' => 'default.jpg'
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
        $video_input = $this->input->post('videourl', true);
        $video_embed = '';

        if (!empty($video_input)) {
            // 1. Konversi ke embed URL
            $video_embed = $this->convert_to_embed($video_input);

            if (empty($video_embed)) {
                $this->session->set_flashdata('error', 'Gagal mengkonversi URL video. Pastikan link benar.');
                redirect('admin/add_materi');
                return;
            }

            // 2. Validasi embed URL
            if (!$this->is_valid_embed_url($video_embed)) {
                $this->session->set_flashdata('error', 'Format embed video tidak valid');
                redirect('admin/add_materi');
                return;
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
            'video'     => $video_embed,
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
/**
 * Validates video URL format and domain with HTTPS check
 */
// Fungsi tambahan untuk validasi embed URL
private function is_valid_embed_url($url) {
    $patterns = [
        'youtube' => '/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+(\?.*)?$/',
        'vimeo'   => '/^https:\/\/player\.vimeo\.com\/video\/[0-9]+(\?.*)?$/',
        'drive'   => '/^https:\/\/drive\.google\.com\/file\/d\/[a-zA-Z0-9_-]+\/preview(\?.*)?$/'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url)) {
            return true;
        }
    }

    return false;
}
private function is_valid_video_url($url) {
    if (empty($url)) return true;
    
    $allowed_domains = [
        'youtube.com',
        'youtu.be',
        'vimeo.com',
        'drive.google.com'
    ];

    // 1. Basic URL validation
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }
    
    // 2. Force HTTPS and clean URL
    $url = $this->clean_video_url($url);

    // 3. Parse and validate components
    $parsed = parse_url($url);
    if (!isset($parsed['host'])) {
        return false;
    }

    // 4. Check against allowed domains
    foreach ($allowed_domains as $domain) {
        if (strpos($parsed['host'], $domain) !== false) {
            return true;
        }
    }

    return false;
}

private function clean_video_url($url) {
    // Remove tracking parameters and unnecessary query strings
    $url = preg_replace('/([&?])(si|feature|ab_channel)=[^&]+/', '', $url);
    $url = preg_replace('/&+$/', '', $url); // Remove trailing &
    
    // Force HTTPS
    if (strpos($url, 'https://') !== 0) {
        $url = 'https://' . str_replace(['http://', 'https://'], '', $url);
    }
    
    return $url;
}

private function convert_to_embed($url) {
    $url = $this->clean_video_url($url);
    $parsed = parse_url($url);
    $host = $parsed['host'] ?? '';

    // --------------------
    // YouTube
    // --------------------
    if (strpos($host, 'youtube.com') !== false || strpos($host, 'youtu.be') !== false) {
        $video_id = '';

        // Short link youtu.be
        if (strpos($host, 'youtu.be') !== false) {
            $video_id = substr($parsed['path'], 1);       // ambil path setelah /
            $video_id = preg_replace('/\?.*/', '', $video_id); // hapus query string
        }
        // Standard YouTube link
        else {
            parse_str($parsed['query'] ?? '', $query);
            $video_id = $query['v'] ?? '';

            // Handle /watch/VIDEO_ID style (jarang)
            if (empty($video_id) && isset($parsed['path'])) {
                preg_match('/\/watch\/([a-zA-Z0-9_-]+)/', $parsed['path'], $matches);
                $video_id = $matches[1] ?? '';
            }
        }

        // Bersihkan video ID dari karakter aneh
        $video_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $video_id);

        return $video_id ? 'https://www.youtube.com/embed/' . $video_id . '?rel=0&modestbranding=1' : '';
    }

    // --------------------
    // Vimeo
    // --------------------
    if (strpos($host, 'vimeo.com') !== false) {
        $video_id = substr($parsed['path'], 1);
        $video_id = preg_replace('/[^0-9]/', '', $video_id);
        return $video_id ? 'https://player.vimeo.com/video/' . $video_id : '';
    }

    // --------------------
    // Google Drive
    // --------------------
    if (strpos($host, 'drive.google.com') !== false) {
        preg_match('/\/file\/d\/([^\/]+)/', $url, $matches);
        return isset($matches[1]) ? 'https://drive.google.com/file/d/' . $matches[1] . '/preview' : '';
    }

    return '';
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
        $this->load->model('M_materi');
        $data['forums'] = $this->M_materi->get_pertemuan_with_forum();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_fordis', $data);
        $this->load->view('admin/partials/foota');
    }
    public function delete_forum($id_pertemuan)
    {
        $this->db->where('id_pertemuan', $id_pertemuan);
        $this->db->delete('forum_diskusi');

        $this->session->set_flashdata('success', '✅ Semua komentar pada pertemuan ini berhasil dihapus.');
        redirect('admin/data_fordis');
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
        public function hapus_soal_quiz($id_soal, $id_quiz)
{
    $this->load->model('Quiz_model');

    if ($this->Quiz_model->hapus_soalquiz($id_soal)) {
        $this->session->set_flashdata('success', '✅ Soal berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', '❌ Gagal menghapus soal.');
    }

    // Balik ke detail quiz admin
    redirect('admin/kelola_quiz/' . $id_quiz);
}
public function delete_quiz($id)
{
    $result = $this->Quiz_model->delete_quizs($id);

    if ($result) {
        $this->session->set_flashdata('success', 'Quiz dan semua data terkait berhasil dihapus.');
    } else {
        $error = $this->db->error();
        $this->session->set_flashdata('error', 'Gagal menghapus quiz: ' . $error['message']);
    }

    redirect('admin/data_quiz'); // pastikan bukan ke detail
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
        $this->form_validation->set_rules('id_mapel', 'Mata Pelajaran', 'required');
        
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
                'id_mapel' => $post_data['id_mapel'],
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
    public function hapus_soal_fix($id_soal)
{
    $hapus = $this->Bank_soal_model->hapus_soal_fix($id_soal);

    if ($hapus) {
        $this->session->set_flashdata('success-delete', 'Soal berhasil dihapus');
    } else {
        $this->session->set_flashdata(
            'error-delete',
            'Soal tidak bisa dihapus karena sudah dipakai di ujian atau sudah dijawab siswa.'
        );
    }

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
    public function delete_ujian($id_ujian)
{
    $this->load->model('Ujian_model');

    if ($this->Ujian_model->hapus_ujian($id_ujian)) {
        $this->session->set_flashdata('success', '✅ Ujian beserta soal & jawaban siswa berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', '❌ Gagal menghapus ujian.');
    }

    redirect('admin/data_ujian');
}
public function data_peserta($id_ujian)
{
    $this->load->model('Ujian_model');
    $data['peserta']  = $this->Ujian_model->get_peserta_ujians($id_ujian);
    $data['ujian'] = $this->Ujian_model->get_ujian_by_ids($id_ujian);
    $data['id_ujian'] = $id_ujian;
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/data_peserta', $data);
    $this->load->view('admin/partials/foota');
}

public function hapus_jawaban_siswa($id_ujian, $nis)
{
    $this->load->model('Ujian_model');
    $hapus = $this->Ujian_model->hapus_jawaban_siswa($id_ujian, $nis);

    if ($hapus) {
        $this->session->set_flashdata('success', 'Jawaban siswa berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menghapus jawaban siswa.');
    }

    redirect('admin/data_peserta/'.$id_ujian);
}


    public function data_pertemuan()
{
    $data['pertemuan_grouped'] = $this->M_materi->get_pertemuan_grouped();

    $this->load->view('admin/partials/nava');
    $this->load->view('admin/data_pertemuan', $data); // ini view baru
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

public function edit($id_pertemuan) {
        $data['pertemuan'] = $this->M_pertemuan->get_by_id($id_pertemuan);
        $pertemuan = $this->db->select('pertemuan.*, materi.id_mapel')
                          ->from('pertemuan')
                          ->join('materi', 'materi.id = pertemuan.id_materi')
                          ->where('pertemuan.id', $id_pertemuan)
                          ->get()->row();

        if (!$pertemuan) {
            $this->session->set_flashdata('error', 'Data pertemuan tidak ditemukan');
            redirect('admin/data_pertemuan');
        }

        // ambil materi hanya sesuai mapel dari pertemuan ini
        $this->load->model('M_materi');
        $materi_list = $this->M_materi->get_by_mapel($pertemuan->id_mapel);

        $data = [
            'pertemuan'   => $pertemuan,
            'materi_list' => $materi_list
        ];

        $data['kelas'] = $this->M_materi->get_all_kelas();

        $this->load->view('admin/partials/nava');
        $this->load->view('admin/update_pertemuan', $data);
        $this->load->view('admin/partials/foota');
    }

public function update_pertemuan($id_pertemuan)
{
    $data = [
        'id_materi' => $this->input->post('id_materi'),
        'id_kelas' => $this->input->post('id_kelas'),
        'pertemuan_ke' => $this->input->post('pertemuan_ke'),
        'tanggal' => $this->input->post('tanggal')
    ];

    $this->M_pertemuan->update($id_pertemuan, $data);
    $this->session->set_flashdata('success', 'Data pertemuan berhasil diperbarui.');
    redirect('admin/data_pertemuan');
}


    public function delete_pertemuan($id_pertemuan) {
        $this->M_pertemuan->delete($id_pertemuan);
        $this->session->set_flashdata('success', 'Data pertemuan berhasil dihapus.');
        redirect('admin/data_pertemuan');
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

public function kelas()
{
    // Ambil data semua kelas dari tabel kelas
    $data['kelas'] = $this->db->get('kelas')->result();

    // Load view seperti struktur kamu
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/data_kelas', $data); // view yang sudah kamu pakai formatnya
    $this->load->view('admin/partials/foota');
}
public function add_kelas() {
    $data['kelas_edit'] = null;
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/add_kelas', $data);
    $this->load->view('admin/partials/foota');
}
public function simpan_kelas() {
    $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|is_unique[kelas.nama_kelas]');
    $this->form_validation->set_rules('tingkat', 'Tingkat', 'required');

    if ($this->form_validation->run() == false) {
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/add_kelas');
        $this->load->view('admin/partials/foota');
    } else {
        $this->load->model('M_materi');
        $data = [
            'nama_kelas' => $this->input->post('nama_kelas', true),
            'tingkat' => $this->input->post('tingkat', true),
            'jurusan' => $this->input->post('jurusan', true)
        ];
        $this->M_materi->insert_kelas($data);
        redirect('admin/kelas');
    }
}

public function edit_kelas($id) {
    $this->load->model('M_materi');
    $data['kelas_edit'] = $this->M_materi->get_kelas_by_id($id);
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/update_kelas', $data);
    $this->load->view('admin/partials/foota');
}
public function update_kelas($id) {
    $this->load->model('M_materi');
    $kelas_lama = $this->M_materi->get_kelas_by_id($id);
    $nama_kelas_baru = $this->input->post('nama_kelas', true);

    // Jika nama berubah, validasi is_unique
    if ($kelas_lama->nama_kelas != $nama_kelas_baru) {
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|is_unique[kelas.nama_kelas]');
    } else {
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required');
    }

    $this->form_validation->set_rules('tingkat', 'Tingkat', 'required');

    if ($this->form_validation->run() == false) {
        $data['kelas_edit'] = $kelas_lama;
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/update_kelas', $data);
        $this->load->view('admin/partials/foota');
    } else {
        $data = [
            'nama_kelas' => $nama_kelas_baru,
            'tingkat' => $this->input->post('tingkat', true),
            'jurusan' => $this->input->post('jurusan', true)
        ];
        $this->M_materi->update_kelas($id, $data);
        redirect('admin/kelas');
    }
}

public function hapus_kelas($id) {
    $this->load->model('M_materi');

    // Cek apakah kelas masih digunakan
    $digunakan = false;

    // Cek di tabel siswa
    $siswa = $this->db->get_where('siswa', ['id_kelas' => $id])->num_rows();
    if ($siswa > 0) $digunakan = true;

    // Cek di tabel materi
    $materi = $this->db->get_where('materi', ['id_kelas' => $id])->num_rows();
    if ($materi > 0) $digunakan = true;

    // Cek di tabel pertemuan
    $pertemuan = $this->db->get_where('pertemuan', ['id_kelas' => $id])->num_rows();
    if ($pertemuan > 0) $digunakan = true;

    if ($digunakan) {
        $this->session->set_flashdata('error', 'Kelas tidak dapat dihapus karena masih digunakan di data lain.');
    } else {
        $this->M_materi->delete_kelas($id);
        $this->session->set_flashdata('success', 'Kelas berhasil dihapus.');
    }

    redirect('admin/kelas');
}

public function data_mapel()
{
    $this->load->model('M_materi');
    $data['mapel'] = $this->M_materi->get_all_mapel();
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/data_mapel', $data);
    $this->load->view('admin/partials/foota');
}
public function add_mapel()
{
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/add_mapel');
    $this->load->view('admin/partials/foota');
}
public function simpan_mapel()
{
    $this->form_validation->set_rules('nama_mapel', 'Nama Mapel', 'required|is_unique[mata_pelajaran.nama_mapel]');

    if ($this->form_validation->run() == false) {
        $this->add_mapel();
    } else {
        $this->load->model('M_materi');
        $data = [
            'nama_mapel' => $this->input->post('nama_mapel', true),
            'deskripsi' => $this->input->post('deskripsi', true)
        ];
        $this->M_materi->insert_mapel($data);
        $this->session->set_flashdata('success', 'Mata pelajaran berhasil ditambahkan.');
        redirect('admin/data_mapel');
    }
}
public function edit_mapel($id)
{
    $this->load->model('M_materi');
    $data['mapel_edit'] = $this->M_materi->get_mapel_by_id($id);
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/update_mapel', $data);
    $this->load->view('admin/partials/foota');
}
public function update_mapel($id)
{
    $this->load->model('M_materi');
    $lama = $this->M_materi->get_mapel_by_id($id);

    $nama_baru = $this->input->post('nama_mapel', true);
    $deskripsi_baru = $this->input->post('deskripsi', true);

    if ($lama->nama_mapel != $nama_baru) {
        $this->form_validation->set_rules('nama_mapel', 'Nama Mapel', 'required|is_unique[mata_pelajaran.nama_mapel]');
    } else {
        $this->form_validation->set_rules('nama_mapel', 'Nama Mapel', 'required');
    }

    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

    if ($this->form_validation->run() == false) {
        $data['mapel_edit'] = $lama;
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/update_mapel', $data);
        $this->load->view('admin/partials/foota');
    } else {
        $data = [
            'nama_mapel' => $nama_baru,
            'deskripsi'  => $deskripsi_baru
        ];
        $this->M_materi->update_mapel($id, $data);
        $this->session->set_flashdata('success', 'Mata pelajaran berhasil diperbarui.');
        redirect('admin/data_mapel');
    }
}
public function hapus_mapel($id)
{
    $this->load->model('M_materi');

    // Cek apakah dipakai di tabel materi
    $digunakan = $this->db->get_where('materi', ['id_mapel' => $id])->num_rows();

    if ($digunakan > 0) {
        $this->session->set_flashdata('error', 'Mapel tidak dapat dihapus karena masih digunakan.');
    } else {
        $this->M_materi->delete_mapel($id);
        $this->session->set_flashdata('success', 'Mapel berhasil dihapus.');
    }

    redirect('admin/data_mapel');
}

    // role admin
    public function data_rps_admin()
    {
        $this->load->model('Rps_model');
        // Ambil semua RPS
        $rps_all = $this->Rps_model->tampil_semua_rps();

        // Grouping per guru
        $data['rps_grouped'] = [];
        foreach ($rps_all as $row) {
            $key = $row->nama_guru . ' - ' . $row->nama_mapel . ' - ' . $row->nama_kelas;
            $data['rps_grouped'][$key][] = $row;
        }
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_rps', $data);
        $this->load->view('admin/partials/foota');
    }

    public function delete_rps_by_admin($id)
    {
        $this->load->model('Rps_model');

        // Ambil data file RPS dulu
        $rps = $this->Rps_model->get_rps_by_id($id);
        if (!$rps) {
            $this->session->set_flashdata('error', 'RPS tidak ditemukan.');
            redirect('admin/data_rps_admin');
        }

        // Hapus file fisik
        $file_path = './assets/rps_uploads/' . $rps->file_rps;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Hapus data di database
        if ($this->Rps_model->delete_rps_by_admin($id)) {
            $this->session->set_flashdata('success', 'RPS berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus RPS.');
        }

        redirect('admin/data_rps_admin');
    }

}
