<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuisioner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // pastikan hanya admin yang bisa akses
        if ($this->session->userdata('user_type') != 'admin') {
            redirect('welcome/admin');
        }
        $this->load->model('Kuisioner_model');
    }

    // list semua kuisioner
    public function index() {
        $data['kuisioner'] = $this->Kuisioner_model->get_all();
        $this->load->view('admin/partials/nava');
        $this->load->view('admin/data_kuisioner', $data);
        $this->load->view('admin/partials/foota');
    }

    // form tambah
    // tambah kuisioner
public function create() {
    if ($this->input->post()) {
        $this->Kuisioner_model->insert([
            'judul'      => $this->input->post('judul'),
            'deskripsi'  => $this->input->post('deskripsi'),
            'target'     => $this->input->post('target'),
            'is_active'  => $this->input->post('is_active'),
            'created_by' => $this->session->userdata('id') // admin id
        ]);
        redirect('kuisioner');
    }
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/add_kuisioner');
    $this->load->view('admin/partials/foota');
}

// edit kuisioner
public function edit($id) {
    $data['kuisioner'] = $this->Kuisioner_model->get_by_id($id);
    if (!$data['kuisioner']) {
        show_404();
    }

    if ($this->input->post()) {
        $this->Kuisioner_model->update($id, [
            'judul'     => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'target'    => $this->input->post('target'),
            'is_active' => $this->input->post('is_active')
        ]);
        redirect('kuisioner');
    }
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/edit_kuisioner', $data);
    $this->load->view('admin/partials/foota');
}


    // hapus
    public function delete($id) {
        $this->Kuisioner_model->delete($id);
        redirect('kuisioner');
    }
    // tampil pertanyaan per kuisioner
public function pertanyaan($kuisioner_id) {
    $data['kuisioner'] = $this->Kuisioner_model->get_by_id($kuisioner_id);
    if (!$data['kuisioner']) {
        show_404();
    }
    $data['pertanyaan'] = $this->Kuisioner_model->get_pertanyaan($kuisioner_id);
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/data_pertanyaan_kuis', $data);
    $this->load->view('admin/partials/foota');
}

// tambah pertanyaan
public function tambah_pertanyaan($kuisioner_id) {
    if ($this->input->post()) {
        $this->Kuisioner_model->insert_pertanyaan([
            'kuisioner_id' => $kuisioner_id,
            'pertanyaan'   => $this->input->post('pertanyaan'),
            'tipe_jawaban' => $this->input->post('tipe_jawaban'),
            'skala_min'    => $this->input->post('skala_min'),
            'skala_max'    => $this->input->post('skala_max'),
            'opsi_pilihan' => $this->input->post('opsi_pilihan') ? json_encode(explode(",", $this->input->post('opsi_pilihan'))) : NULL,
            'urutan'       => $this->input->post('urutan')
        ]);
        $this->session->set_flashdata('success', 'Pertanyaan berhasil ditambahkan');
        redirect('kuisioner/pertanyaan/'.$kuisioner_id);
    }
    $data['kuisioner_id'] = $kuisioner_id;
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/add_pertanyaan_kuis', $data);
    $this->load->view('admin/partials/foota');
}

// edit pertanyaan
public function edit_pertanyaan($id) {
    $data['pertanyaan'] = $this->Kuisioner_model->get_pertanyaan_by_id($id);
    if (!$data['pertanyaan']) {
        show_404();
    }
    if ($this->input->post()) {
        $this->Kuisioner_model->update_pertanyaan($id, [
            'pertanyaan'   => $this->input->post('pertanyaan'),
            'tipe_jawaban' => $this->input->post('tipe_jawaban'),
            'skala_min'    => $this->input->post('skala_min'),
            'skala_max'    => $this->input->post('skala_max'),
            'opsi_pilihan' => $this->input->post('opsi_pilihan') ? json_encode(explode(",", $this->input->post('opsi_pilihan'))) : NULL,
            'urutan'       => $this->input->post('urutan')
        ]);
        $this->session->set_flashdata('success', 'Pertanyaan berhasil diperbarui');
        redirect('kuisioner/pertanyaan/'.$data['pertanyaan']->kuisioner_id);
    }
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/edit_pertanyaan_kuis', $data);
    $this->load->view('admin/partials/foota');
}

// hapus pertanyaan
public function delete_pertanyaan($id) {
    $pertanyaan = $this->Kuisioner_model->get_pertanyaan_by_id($id);
    if ($pertanyaan) {
        $this->Kuisioner_model->delete_pertanyaan($id);
        $this->session->set_flashdata('success', 'Pertanyaan berhasil dihapus');
        redirect('kuisioner/pertanyaan/'.$pertanyaan->kuisioner_id);
    }
    show_404();
}
// Hasil analisis kuisioner
public function hasil($kuisioner_id) {
    // Ambil data kuisioner
    $data['kuisioner']   = $this->Kuisioner_model->get_by_id($kuisioner_id);
    if (!$data['kuisioner']) {
        show_404();
    }

    // Ambil semua pertanyaan
    $data['pertanyaan']  = $this->Kuisioner_model->get_pertanyaan($kuisioner_id);
    $data['hasil']       = [];
    $data['hasil_word']  = []; // Tambahkan untuk hasil seperti word

    // Analisis per pertanyaan (DUA CARA: lama & baru seperti word)
    foreach ($data['pertanyaan'] as $p) {
        // Method lama (statistik deskriptif)
        $stat = $this->Kuisioner_model->analisis_pertanyaan(
            $kuisioner_id,
            $p->id,
            $p->tipe_jawaban
        );
        $data['hasil'][$p->id] = $stat;
        
        // Method baru seperti word (hanya untuk tipe skala)
        if ($p->tipe_jawaban == 'skala') {
            $data['hasil_word'][$p->id] = $this->Kuisioner_model->analisis_pertanyaan_deskriptif(
                $kuisioner_id, 
                $p->id
            );
        }
    }
    $data['distribusi_total'] = $this->Kuisioner_model->get_total_distribusi($kuisioner_id);
    $data['distribusi_per_pertanyaan'] = $this->Kuisioner_model->get_total_distribusi_per_pertanyaan($kuisioner_id);
    
    // Hitung persentase distribusi total
    $total_jawaban = $data['total_word']['total_responden'] ?? 0;
    $data['persentase_distribusi'] = [];
    
    foreach ($data['distribusi_total'] as $dist) {
        $persentase = $total_jawaban > 0 ? ($dist->total / $total_jawaban) * 100 : 0;
        $data['persentase_distribusi'][$dist->jawaban_skala] = $persentase;
    }

    // Analisis total - gunakan yang seperti word
    $data['grand_mean'] = $this->Kuisioner_model->analisis_total($kuisioner_id, 'skala');
    $data['total_word'] = $this->Kuisioner_model->analisis_total_deskriptif($kuisioner_id);

    // Load view
    $this->load->view('admin/partials/nava');
    $this->load->view('admin/data_hasil_kuisioner', $data);
    $this->load->view('admin/partials/foota');
}

}
