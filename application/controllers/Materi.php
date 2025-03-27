<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Materi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('disqus');
        $this->load->model('M_materi');
    }
    public function index() 
    {
        $query = $this->db->get_where('materi', ['id' => $id]);

                if ($query->num_rows() > 0) {
                    $data['materi'] = $query->row();
                } else {
                    $data['materi'] = null; // Set null jika tidak ditemukan
                }

                $this->load->view('materi/belajar', $data);

    }
    function generateMateri($materi){
    
        $data['materi'] = $this->list_materi[$materi];
        $data['user'] = $this->db->get_where('siswa', ['email' =>
            $this->session->userdata('email')])->row_array();
        $this->load->view('materi/navm');
        $this->load->view('materi/'.str_replace('_', '-', $materi), $data);
        $this->load->view('template/footer');
    }

    public function belajar($id) {
        $this->load->model(['M_materi', 'Forum_model']);
        
        // Ambil data
        $data['materi'] = $this->M_materi->get_materi_by_id($id);
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['forum'] = $this->Forum_model->get_komentar_by_materi($id);
        $data['disqus'] = $this->disqus->get_html();
        
        // Debug akhir sebelum load view
        if(empty($data['materi'])) {
            show_404();
            return;
        }
        
        $this->load->view('materi/navm');
        $this->load->view('materi/belajar', $data);
    }
}
