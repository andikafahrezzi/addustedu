<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Forum extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Forum_model');
    }

    public function index($materi_id) {
        $data['forums'] = $this->Forum_model->get_forums_by_materi($materi_id);
        $nama_user = $this->session->userdata('nis');
        if (!$nama_user) {
            echo "Error: Nama user tidak ditemukan di session!";
            return;
        }

        $this->load->view('forum/index', $data);
    }

    public function tambah_topik() {
        $data = [
            'materi_id' => $this->input->post('materi_id'),
            'judul' => $this->input->post('judul')
        ];
        $this->Forum_model->add_forum($data);
        redirect('forum/index/' . $this->input->post('materi_id'));
    }

    public function komentar($forum_id) {
        $data['forum'] = $this->Forum_model->get_forum_comments($forum_id);
        $this->load->view('forum/komentar', $data);
    }
        public function tambah_komentar() {
            // Validasi session
            if (!$this->session->userdata('nis')) {
                redirect('auth');
            }
    
            // Ambil data siswa
            $siswa = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
            if (!$siswa) {
                $this->session->set_flashdata('error', 'Data siswa tidak ditemukan');
                redirect('auth');
            }
    
            // Validasi input
            $this->form_validation->set_rules('komentar', 'Komentar', 'required');
            $this->form_validation->set_rules('materi_id', 'Materi ID', 'required|numeric');
            
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('materi/belajar/' . $this->input->post('materi_id'));
            }
    
            // Siapkan data komentar
            $data = [
                'materi_id' => $this->input->post('materi_id'),
                'user'      => $siswa['nama'],
                'komentar'  => $this->input->post('komentar'),
                'parent_id' => $this->input->post('parent_id') ?: NULL,
                'tanggal'   => date('Y-m-d H:i:s')
            ];
    
            // Simpan ke database
            if ($this->Forum_model->tambah_komentar($data)) {
                $this->session->set_flashdata('success', 'Komentar berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan komentar');
            }
    
            redirect('materi/belajar/' . $data['materi_id']);
        }
    

    public function get_nama_siswa()
    {
        $nis = $this->session->userdata('nis');
        if (!$nis) {
            return "User tidak ditemukan";
        }

        $siswa = $this->db->get_where('siswa', ['nis' => $nis])->row();
        return $siswa ? $siswa->nama : "Nama tidak ditemukan";
    }
    public function diskusi($materi_id) {
        $data['forum'] = $this->Forum_model->get_komentar_by_materi($materi_id);
    
        // Debugging: Cek apakah data duplikat
        echo "<pre>";
        print_r($data['forum']);
        echo "</pre>";
        exit(); // Hentikan sementara untuk melihat hasil
    
        $this->load->view('materi/belajar', $data);
    }
    

}
