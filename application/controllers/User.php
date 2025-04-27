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
        // if (!$this->session->userdata('email')) {
        //     redirect('welcome');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
    
        if ($data['user']) {
            $kelas_siswa = $data['user']['kelas'];
            $data['kelas_siswa'] = $kelas_siswa;
    
            // Ambil data materi berdasarkan kelas
            $this->db->select('materi.*, guru.nip, guru.nama_guru');
            $this->db->from('materi');
            $this->db->join('guru', 'guru.nip = materi.id_guru');
            $this->db->where('materi.kelas', $kelas_siswa);
            $materi = $this->db->get()->result_array();
    
            $mapel_data = [];
            foreach ($materi as $m) {
                $mapel = $m['nama_mapel'];
                $nip = $m['id_guru']; // Pastikan kamu ambil NIP di query
    
                // Gabungkan NIP dan nama agar tetap bisa tampil nama guru tapi unik berdasarkan NIP
                $mapel_data[$mapel][$nip][] = $m;
            }
    
            // Ambil ujian berdasarkan kelas dan mapel
            $data['mapel_data'] = $mapel_data;
    
            // Di sini kita perlu mengambil ujian berdasarkan kelas siswa dan mapel
            $data['ujian_list'] = $this->Ujian_model->get_ujian_by_mapel_and_kelas($kelas_siswa);
    
            // Memanggil view
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
