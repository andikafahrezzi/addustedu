<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->session->set_flashdata('not-login', 'Gagal!');
        if (!$this->session->userdata('nip')) {
            redirect('welcome/guru');
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('guru', ['nip' =>
            $this->session->userdata('nip')])->row_array();

        $this->load->view('guru/index');
    }

    public function add_materi()
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required');
    
    if ($this->form_validation->run() == false) {
        $this->load->view('guru/add_materi');
    } else {
        // Load library upload terlebih dahulu
        $this->load->library('upload');

        // **1️⃣ Proses Upload Video**
        $video_materi = '';
        if (!empty($_FILES['video']['name'])) {
            $config_video['upload_path']   = './assets/materi_video/';
            $config_video['allowed_types'] = 'mp4|avi|mov|wmv';
            $config_video['max_size']      = 100000;

            $this->upload->initialize($config_video);

            if ($this->upload->do_upload('video')) {
                $upload_data = $this->upload->data();
                $video_materi = 'assets/materi_video/' . $upload_data['file_name'];
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
                $modul = 'assets/materi_modul/' . $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
                redirect('guru/add_materi');
            }
        }

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
}
