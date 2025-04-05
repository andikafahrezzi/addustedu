<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->session->set_flashdata('not-login', 'Gagal!');
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);  
        if (!$this->session->userdata('nip')) {
            redirect('welcome/guru');
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('guru', ['nip' => $this->session->userdata('nip')])->row_array();

        $this->load->view('guru/index');
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
        $this->load->view('guru/add_materi', $data);
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
}

    public function update_materi()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required');
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);
        
        if ($this->form_validation->run() == false) {
            $nip = $this->session->userdata('nip'); // atau 'id_guru', sesuai yang kamu pakai
    
            // Ambil data user dari tabel guru
            $data['user'] = $this->db->get_where('guru', ['nip' => $nip])->row_array();
            $data['materi'] = $this->M_materi->tampil_materi_guru($nip)->result();
            $this->load->view('guru/navug');
            $this->load->view('guru/update_materi', $data);
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
        redirect('guru/data_materi');

    }
}
