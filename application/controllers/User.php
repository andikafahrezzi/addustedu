<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Ujian_model');
        // $this->session->set_flashdata('not-login', 'Gagal!');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'siswa') {
            redirect('welcome');
        }
    }
public function index()
{
// Controller (misal di User.php -> function index() atau dashboard)
$this->load->model('Ujian_model');

// Ambil data siswa dari sesi
$this->db->select('siswa.*, kelas.nama_kelas, kelas.tingkat, kelas.jurusan');
$this->db->from('siswa');
$this->db->join('kelas', 'kelas.id = siswa.id_kelas');
$this->db->where('siswa.nis', $this->session->userdata('nis'));
$data['user'] = $this->db->get()->row_array();

if ($data['user']) {
    $id_kelas_siswa = $data['user']['id_kelas'];
    $data['kelas_siswa'] = $id_kelas_siswa;

    // Ambil nama_kelas dari id_kelas siswa
    $kelas = $this->db->get_where('kelas', ['id' => $id_kelas_siswa])->row();
    $nama_kelas_siswa = $kelas ? $kelas->nama_kelas : '';

    // Ambil materi berdasarkan nama_kelas
    $this->db->select('materi.*, guru.nama_guru, guru.nip, mata_pelajaran.nama_mapel, kelas.nama_kelas');
    $this->db->from('materi');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas');
    $this->db->where('kelas.nama_kelas', $nama_kelas_siswa); // 🔍 berbasis nama_kelas
    $this->db->order_by('kelas.nama_kelas', 'ASC'); // 📋 agar terurut

    $materi = $this->db->get()->result_array();



    // Kelompokkan berdasarkan mapel dan guru
    $mapel_data = [];
    foreach ($materi as $m) {
        $mapel = $m['nama_mapel'];
        $nip = $m['nip'];
        $id_mapel = $m['id_mapel'];
        $mapel_data[$mapel][$nip][$id_mapel][] = $m;
    }
    $data['mapel_data'] = $mapel_data;

    // Ambil semua pertemuan untuk kelas siswa
    $this->db->select('pertemuan.*, materi.deskripsi AS deskripsi_materi, guru.nip AS id_guru, materi.id_mapel');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->where('pertemuan.id_kelas', $id_kelas_siswa);
    $pertemuan = $this->db->get()->result_array();
    $data['pertemuan'] = $pertemuan;

    // Ambil ujian per guru dan mapel
    $ujian_data = [];
    foreach ($mapel_data as $mapel => $guru_list) {
        foreach ($guru_list as $nip => $mapel_list) {
            foreach ($mapel_list as $id_mapel => $materi_list) {
                $ujian_data[$nip][$id_mapel] = $this->Ujian_model->get_ujian_by_kelas($id_kelas_siswa, $nip, $id_mapel);
            }
        }
    }
    $data['ujian_data'] = $ujian_data;

    $this->load->view('user/navu');
    $this->load->view('user/index', $data);
    $this->load->view('user/foots');
} else {
    redirect('welcome/');
}

}




    public function registration()
    {
        $this->load->view('user/registration');
        $this->load->view('user/foots');
    }

    public function registration_act()
    {
        $this->form_validation->set_rules('nis', 'Nis', 'min_length[5]|trim|numeric|is_unique[siswa.nis]', [
            'is_unique' => 'nis ini telah digunakan!',
            'numeric' => 'NIS harus berupa angka!',
            'min_length' => 'NIS minimal 5 angka!'
        ]);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|min_length[4]', [
            'required' => 'Harap isi kolom username.',
            'min_length' => 'Nama terlalu pendek.',
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Harap isi kolom email.',
            'valid_email' => 'Masukan email yang valid.',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[retype_password]', [
            'required' => 'Harap isi kolom Password.',
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password terlalu pendek',
        ]);
        $this->form_validation->set_rules('retype_password', 'Password', 'required|trim|matches[password]', [
            'matches' => 'Password tidak sama!',
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('template/nav');
            $this->load->view('user/registration');
            $this->load->view('template/footer');
        } else {
            $nis = $this->input->post('nis', true);
            $data = [
                'nis' => htmlspecialchars($nis),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'kelas' => htmlspecialchars($this->input->post('kelas', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'is_active' => 1,
                'date_created' => time(),
            ];

            //siapkan token

            // $token = base64_encode(random_bytes(32));
            // $user_token = [
            //     'nis' => $email,
            //     'token' => $token,
            //     'date_created' => time(),
            // ];

            $this->db->insert('siswa', $data);
            // $this->db->insert('token', $user_token);

            // $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('success-reg', 'Berhasil!');
            redirect(base_url('admin'));
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'ini email disini',
            'smtp_pass' => 'Isi Password gmail disini',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
        ];

        $this->email->initialize($config);

        $data = array(
            'name' => 'syauqi',
            'link' => ' ' . base_url() . 'welcome/verify?email=' . $this->input->post('email') . '& token' . urlencode($token) . '"',
        );

        $this->email->from('addusteduEducations@gmail.com', 'addustedu');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $link =
            $this->email->subject('Verifikasi Akun');
            $body = $this->load->view('template/email-template.php', $data, true);
            $this->email->message($body);
        } else {
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die();
        }
    }
    

}
