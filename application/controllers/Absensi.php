<?php
class Absensi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Absensi_model');
    }

    // LIHAT ABSENSI DENGAN VALIDATION CHECK
    public function lihat($id_pertemuan) {
        $data['title'] = "Rekap Absensi";
        
        // Ambil data absensi (auto-handle validity)
        $data['absensi'] = $this->Absensi_model->get_absensi_pertemuan($id_pertemuan);
        
        // Info validity untuk UI
        $data['validity_info'] = $this->Absensi_model->get_validity_info($id_pertemuan);
        $data['statistik'] = $this->Absensi_model->get_statistik($id_pertemuan);
        $data['pengaturan'] = $this->Absensi_model->get_pengaturan();
        $data['id_pertemuan'] = $id_pertemuan;
        
        // Info pertemuan
        $data['pertemuan'] = $this->db->where('id', $id_pertemuan)->get('pertemuan')->row_array();
        $data['batas_waktu_info'] = $this->Absensi_model->get_info_batas_waktu($id_pertemuan);


        $this->load->view('guru/navug', $data);
        $this->load->view('guru/data_absensi', $data);
        $this->load->view('guru/footg');
    }

    // HITUNG ULANG & SIMPAN DENGAN VERSION BARU
    public function hitung($id_pertemuan) {
        $result = $this->Absensi_model->hitung_dan_simpan_absensi($id_pertemuan);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Absensi berhasil dihitung ulang dengan data terbaru');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghitung absensi');
        }
        
        redirect('absensi/lihat/' . $id_pertemuan);
    }
}