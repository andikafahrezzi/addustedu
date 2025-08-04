<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    public function index() {
        $this->load->view('template/nav');
        $this->load->view('index');
        $this->load->view('template/footer');
    }

    // Login Siswa
public function validateLogin() {
    $this->form_validation->set_rules('nis', 'NIS', 'trim|required|numeric|min_length[5]', [
        'required' => 'Harap isi bidang NIS!',
        'numeric' => 'NIS harus berupa angka!',
        'min_length' => 'NIS minimal 5 angka!'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'trim|required', [
        'required' => 'Harap isi bidang password!',
    ]);

    if ($this->form_validation->run() == false) {
        // Simpan error ke flashdata masing-masing
        $errors = $this->form_validation->error_array();

        $this->session->set_flashdata('false-login', true);
        $this->session->set_flashdata('nis_error', $errors['nis'] ?? '');
        $this->session->set_flashdata('password_error', $errors['password'] ?? '');
        $this->session->set_flashdata('old_nis', set_value('nis'));
        redirect('welcome');
    } else {
        $this->siswa_login_process();
    }
}


    private function siswa_login_process() {
        $nis = $this->input->post('nis');
        $password = $this->input->post('password');

        $user = $this->db->get_where('siswa', ['nis' => $nis])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    // Bersihkan session lama
                    $this->session->unset_userdata(['nip', 'nama_guru', 'user_type', 'logged_in']);
                    
                    // Set session baru
                    $data = [
                        'nis' => $user['nis'],
                        'nama' => $user['nama'],
                        'user_type' => 'siswa',
                        'logged_in' => true
                    ];
                    $this->session->set_userdata($data);
                    
                    redirect(base_url('user')); // Arahkan ke controller siswa
                } else {
                    $this->session->set_flashdata('fail-pass', 'Password salah!');
                    redirect(base_url('welcome'));
                }
            } else {
                $this->session->set_flashdata('fail-email', 'Akun tidak aktif!');
                redirect(base_url('welcome'));
            }
        } else {
            $this->session->set_flashdata('fail-login', 'NIS tidak terdaftar!');
            redirect(base_url('welcome'));
        }
    }

    // Login Guru
    public function guru() {
        $this->form_validation->set_rules('nip', 'Nip', 'trim|required|numeric|min_length[5]', [
            'required' => 'Harap isi bidang email!',
            'numeric' => 'NIP harus berupa angka!',
            'min_length' => 'NIP minimal 5 angka!',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Harap isi bidang password!',
        ]);
        
        if ($this->form_validation->run() == false) {
            $this->load->view('guru/login');
        } else {
            $this->guru_login_process();
        }
    }

    private function guru_login_process() {
        $nip = $this->input->post('nip');
        $password = $this->input->post('password');

        $user = $this->db->get_where('guru', ['nip' => $nip])->row_array();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Bersihkan session lama
                $this->session->unset_userdata(['nis', 'nama', 'user_type', 'logged_in']);
                
                $data = [
                    'nip' => $user['nip'],
                    'nama_guru' => $user['nama_guru'],
                    'user_type' => 'guru',
                    'logged_in' => true
                ];
                $this->session->set_userdata($data);
                redirect(base_url('guru'));
            } else {
                $this->session->set_flashdata('fail-pass', 'Password salah!');
                redirect(base_url('welcome/guru'));
            }
        } else {
            $this->session->set_flashdata('fail-login', 'NIP tidak terdaftar!');
            redirect(base_url('welcome/guru'));
        }
    }

    // Logout untuk semua user
    public function logout() {
        $this->session->unset_userdata(['nis', 'nip', 'nama', 'nama_guru', 'email', 'user_type', 'logged_in']);
        $this->session->sess_destroy();
        redirect('welcome/admin');
    }

    public function admin()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
            'required' => 'Harap isi bidang email!',
            'valid_email' => 'Email tidak valid!',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Harap isi bidang password!',
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/login');
        } else {
            //validasi sukses
            $this->adminlogin();
        }
    }

    private function adminlogin()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('admin', ['email' => $email])->row_array();

        if ($user) {
            //cek password
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id' => $user['id'], // penting untuk created_by
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'user_type' => 'admin', // tambahkan ini
                    'logged_in' => true // tambahkan status login
                ];
                $this->session->set_userdata($data);
                redirect(base_url('admin'));
            } else {
                $this->session->set_flashdata('fail-pass', 'Password salah!');
                redirect(base_url('welcome/admin'));
            }
        } else {
            $this->session->set_flashdata('fail-login', 'Email tidak terdaftar!');
            redirect(base_url('welcome/admin'));
        }
    }

    public function tentang()
    {
        $this->load->view('template/nav');
        $this->load->view('tentang');
        $this->load->view('template/footer');
    }

    public function pelajaran()
    {
        $this->load->view('template/nav');
        $this->load->view('pelajaran');
        $this->load->view('template/footer');
    }

    public function kontak()
    {
        $this->load->view('template/nav');
        $this->load->view('kontak');
        $this->load->view('template/footer');
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('siswa', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('token', ['token => $token'])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (600 * 600 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('siswa');

                    $this->db->delete('token', ['email' => $email]);
                    $this->session->set_flashdata('success-verify', 'Bserhasil!');
                    redirect(base_url('welcome'));
                } else {
                    $this->db->delete('siswa', ['email' => $email]);
                    $this->db->delete('token', ['email' => $email]);

                    $this->session->set_flashdata('fail-token-expired', 'gagal');
                    redirect(base_url('welcome'));
                }
            } else {
                $this->session->set_flashdata('fail-token', 'gagal');
                redirect(base_url('welcome'));
            }
        } else {
            $this->session->set_flashdata('fail-verify', 'gagal');
            redirect(base_url('welcome'));
        }
    }


    public function email()
    {
        $this->load->view('template/email-template');
    }

    
    public function logouts()
    {
        $this->session->unset_userdata('nis');
        $this->session->set_flashdata('success-logout', 'Berhasil!');
        redirect(base_url('welcome'));
    }
    public function logoutg()
    {
        $this->session->unset_userdata('nip');
        $this->session->set_flashdata('success-logout', 'Berhasil!');
        redirect(base_url('welcome/guru'));
    }
}
