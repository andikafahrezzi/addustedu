<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Forum extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Forum_model');
    }

    public function index() {
        
        $this->load->view('materi/navm');
        $this->load->view('materi/belajar');
        $this->load->view('materi/footm');
    }

    public function tambah_komentar()
    {
        if (!$this->session->userdata('nis')) {
            redirect('welcome');
        }
    
        $siswa = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        if (!$siswa) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan');
            redirect('welcome');
        }
    
        $this->form_validation->set_rules('komentar', 'Komentar', 'required');
        $this->form_validation->set_rules('materi_id', 'Materi ID', 'required|numeric');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('materi/belajar/' . $this->input->post('materi_id'));
        }
    
        // FIX: ambil dari POST
        $materi_id = $this->input->post('materi_id');
        $komentar = $this->input->post('komentar');
    
        $guru = $this->Forum_model->getGuruByMateri($materi_id);
        if (!$guru || empty($guru->email)) {
            $this->session->set_flashdata('error', 'Email guru tidak ditemukan.');
            redirect('materi/belajar/' . $materi_id);
        }
    
        // Kirim email ke guru
        $this->email->from('addustedu@noreply', 'E-Learning');
        $this->email->to($guru->email);
        $this->email->subject('Komentar Baru di Forum Diskusi');
        $this->email->message("Ada komentar baru dari siswa di forum materi: <b>{$materi_id}</b><br><br>Komentar:<br>{$komentar}");
    
        if (!$this->email->send()) {
            $this->session->set_flashdata('error', 'Komentar terkirim, tapi email gagal dikirim.');
            log_message('error', print_r($this->email->print_debugger(), true)); // log error ke log CI
        }
    
        // Simpan komentar ke DB
        $data = [
            'nis' => $this->session->userdata('nis'),
            'materi_id' => $materi_id,
            'user'      => $siswa['nama'],
            'komentar'  => $komentar,
            'parent_id' => $this->input->post('parent_id') ?: NULL,
            'tanggal'   => date('Y-m-d H:i:s')
        ];
    
        if ($this->Forum_model->tambah_komentar($data)) {
            $this->session->set_flashdata('success-add', 'Komentar berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error-comment', 'Gagal menambahkan komentar');
        }
    
        redirect('materi/belajar/' . $materi_id);
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

    public function edit_komentar() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment_id', 'Comment ID', 'required');
        $this->form_validation->set_rules('komentar', 'Komentar', 'required|trim');
    
        if ($this->form_validation->run()) {
            $comment_id = $this->input->post('comment_id');
            $nis = $this->session->userdata('nis');
            
            // Verifikasi kepemilikan komentar
            $comment = $this->db->get_where('forum_diskusi', [
                'id' => $comment_id,
                'nis' => $nis
            ])->row();
    
            if ($comment) {
                $this->db->where('id', $comment_id)
                         ->update('forum_diskusi', [
                             'komentar' => $this->input->post('komentar'),
                             'updated_at' => date('Y-m-d H:i:s')
                         ]);
                $this->session->set_flashdata('success-edit', 'Komentar berhasil diupdate');
            } else {
                $this->session->set_flashdata('error-comment', 'Anda tidak memiliki izin mengedit komentar ini');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function hapus_komentar($comment_id) {
        $nis = $this->session->userdata('nis');
        
        $this->db->where('id', $comment_id)
                 ->where('nis', $nis)
                 ->delete('forum_diskusi');
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function tesEmail()
{
    $this->load->library('email'); // load library email

    $this->email->from('your_email@gmail.com', 'E-Learning'); // email pengirim
    $this->email->to('guru@example.com'); // email tujuan

    $this->email->subject('Tes Email dari CodeIgniter');
    $this->email->message('Halo! Ini adalah percobaan kirim email dari CodeIgniter 3.');

    if ($this->email->send()) {
        echo "Email berhasil dikirim!";
    } else {
        echo "Email gagal dikirim:";
        echo "<pre>";
        print_r($this->email->print_debugger()); // debug jika error
        echo "</pre>";
    }
}

}
