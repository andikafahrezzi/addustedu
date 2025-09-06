<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pertemuan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_pertemuan');
        if (!$this->session->userdata('nip')) {
            redirect('auth/login');
        }
    }

    // Index - List semua pertemuan
public function index() {
    $this->load->library('pagination');
    $nip = $this->session->userdata('nip');
    
    // Handle filters
    $filters = [];
    if ($this->input->get('submit')) {
        $filters = [
            'mapel' => $this->input->get('mapel'),
            'kelas' => $this->input->get('kelas'),
            'keyword' => $this->input->get('keyword')
        ];
    }
    
    // Pagination config
    $config['base_url'] = site_url('pertemuan');
    $config['total_rows'] = $this->M_pertemuan->count_pertemuan($nip, $filters);
    $config['per_page'] = 10;
    $config['reuse_query_string'] = TRUE;
    $config['page_query_string'] = TRUE;
    
    // Pagination styling
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';
    $config['next_link'] = '&raquo;';
    $config['prev_link'] = '&laquo;';
    $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close'] = '</span></li>';
    $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close'] = '</span></li>';
    
    $this->pagination->initialize($config);
    
    $page = $this->input->get('per_page') ?: 0;
    
    $data['pertemuan'] = $this->M_pertemuan->get_pertemuan_paginated($nip, $config['per_page'], $page, $filters);
    $data['pagination'] = $this->pagination->create_links();
    $data['mapel_list'] = $this->M_pertemuan->get_mapel_by_guru($nip);
    $data['kelas_list'] = $this->M_pertemuan->get_kelas_by_guru($nip);
    $data['filters'] = $filters;
    
    $this->load->view('guru/navug');
    $this->load->view('guru/data_pertemuan', $data);
    $this->load->view('guru/footg');
}

    // Tambah pertemuan
// Di controller tambah()
// Di controller tambah()
public function tambah() {
    $nip = $this->session->userdata('nip');
    
    $this->load->model('M_pertemuan');
    $data['materi_list'] = $this->M_pertemuan->get_all_materi();
    $data['mapel_list'] = $this->M_pertemuan->get_mapel_by_guru($nip);
    $data['kelas_list'] = $this->M_pertemuan->get_kelas_by_guru($nip);
    
    $this->load->view('guru/navug');
    $this->load->view('guru/add_pertemuan', $data);
    $this->load->view('guru/footg');
}

// AJAX untuk get materi berdasarkan mapel dan kelas
public function get_materi_ajax() {
    // Handle both POST and GET
    $id_mapel = $this->input->post('id_mapel') ?: $this->input->get('id_mapel');
    $id_kelas = $this->input->post('id_kelas') ?: $this->input->get('id_kelas');
    
    $nip = $this->session->userdata('nip');
    
    if (!$nip) {
        show_error('User not authenticated', 401);
    }
    
    $this->load->model('M_pertemuan');
    $materi = $this->M_pertemuan->get_materi_by_mapel_kelas($nip, $id_mapel, $id_kelas);
    
    header('Content-Type: application/json');
    echo json_encode($materi);
    exit;
}

    // Get next pertemuan number via AJAX
    public function get_next_pertemuan() {
        $id_materi = $this->input->post('id_materi');
        $next_pertemuan = $this->M_pertemuan->get_next_pertemuan($id_materi);
        echo json_encode(['next_pertemuan' => $next_pertemuan]);
    }

    // Get kelas by materi via AJAX
    public function get_kelas_materi() {
        $id_materi = $this->input->post('id_materi');
        $kelas = $this->M_pertemuan->get_kelas_by_materi($id_materi);
        echo json_encode($kelas);
    }

    // Simpan pertemuan
public function simpan()
{
    $this->load->model('M_pertemuan');
    $id_guru = $this->session->userdata('nip'); // ambil dari session

    // Ambil input dari form
    $id_materi     = $this->input->post('id_materi');
    $id_kelas      = $this->input->post('id_kelas');
    $pertemuan_ke  = $this->input->post('pertemuan_ke');
    $tanggal       = $this->input->post('tanggal');

    // Ambil id_mapel dari materi
    $materi = $this->db->get_where('materi', ['id' => $id_materi])->row();
    $id_mapel = $materi ? $materi->id_mapel : null;

    // Cek duplikasi pertemuan
    if ($this->M_pertemuan->is_pertemuan_exists($id_mapel, $id_kelas, $pertemuan_ke, $id_guru)) {
        $this->session->set_flashdata(
            'error',
            'Pertemuan ke-' . $pertemuan_ke . ' untuk mapel dan kelas ini sudah ada.'
        );
        redirect('pertemuan/tambah');
        return;
    }

    // Data yang akan disimpan
    $data = [
        'id_materi'    => $id_materi,
        'id_kelas'     => $id_kelas,
        'pertemuan_ke' => $pertemuan_ke,
        'tanggal'      => $tanggal,
        'id_guru'      => $id_guru,
    ];

    // Simpan ke tabel pertemuan
    $this->db->insert('pertemuan', $data);

    $this->session->set_flashdata('success', 'Pertemuan berhasil disimpan.');
    redirect('pertemuan');
}



public function get_materi_by_mapel()
{
    $id_mapel = $this->input->post('id_mapel');
    $nip = $this->session->userdata('nip');
    $materi = $this->M_pertemuan->get_materi_by_mapel($id_mapel, $nip);
    echo json_encode($materi);
}


    // Edit pertemuan
   public function edit($id) {
    $nip = $this->session->userdata('nip');
    $data['pertemuan'] = $this->M_pertemuan->get_pertemuan_by_id($id);
    
    // Validasi ownership
    if (!$data['pertemuan'] || $data['pertemuan']->id_guru != $nip) {
        show_404();
    }
    
    $this->load->view('guru/navug');
    $this->load->view('guru/edit_pertemuan', $data);
    $this->load->view('guru/footg');
}
    // Update pertemuan
    public function update($id)
{
    $this->load->model('M_pertemuan');
    $id_guru       = $this->session->userdata('nip');
    $id_materi     = $this->input->post('id_materi');
    $id_kelas      = $this->input->post('id_kelas');
    $pertemuan_ke  = $this->input->post('pertemuan_ke');
    $tanggal       = $this->input->post('tanggal');

    // Ambil id_mapel dari materi
    $materi = $this->db->get_where('materi', ['id' => $id_materi])->row();
    $id_mapel = $materi ? $materi->id_mapel : null;

    // Cek apakah duplikat pertemuan (kecuali dirinya sendiri)
    if ($this->M_pertemuan->is_pertemuan_exists($id_mapel, $id_kelas, $pertemuan_ke, $id_guru, $id)) {
        $this->session->set_flashdata(
            'error',
            'Pertemuan ke-' . $pertemuan_ke . ' untuk mapel dan kelas ini sudah ada.'
        );
        redirect('pertemuan/edit/' . $id);
        return;
    }

    $data = [
        'id_materi'    => $id_materi,
        'id_kelas'     => $id_kelas,
        'pertemuan_ke' => $pertemuan_ke,
        'tanggal'      => $tanggal,
        'id_guru'      => $id_guru,
    ];

    $this->db->where('id', $id);
    $this->db->update('pertemuan', $data);

    $this->session->set_flashdata('success', 'Pertemuan berhasil diperbarui.');
    redirect('pertemuan');
}


    // Delete pertemuan
   public function delete($id) {
    $nip = $this->session->userdata('nip');
    
    // Validasi ownership
    $pertemuan = $this->M_pertemuan->get_pertemuan_by_id($id);
    if (!$pertemuan || $pertemuan->id_guru != $nip) {
        show_404();
    }
    
    // Check dependencies
    $dependencies = $this->M_pertemuan->check_pertemuan_dependencies($id);
    
    if (!empty($dependencies)) {
        $message = "Tidak dapat menghapus pertemuan karena masih memiliki: " . implode(', ', $dependencies);
        $this->session->set_flashdata('error', $message);
    } else {
        if ($this->M_pertemuan->delete_pertemuan($id)) {
            $this->session->set_flashdata('success', 'Pertemuan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pertemuan!');
        }
    }
    
    redirect('pertemuan');
}
    
}