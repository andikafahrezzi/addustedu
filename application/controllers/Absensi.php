<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

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
    public function export_excel($id_pertemuan){
        $this->load->model('Absensi_model');
        $data = $this->Absensi_model->get_absensi_per_pertemuan($id_pertemuan);

        $info = $this->Absensi_model->get_info_pertemuan($id_pertemuan);

        $kelas = $info['nama_kelas'] ?? 'Kelas';
        $mapel = $info['nama_mapel'] ?? 'Mapel';

        // Bersihkan nama agar bebas karakter ilegal
        $kelas = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $kelas);
        $mapel = preg_replace('/[^a-zA-Z0-9_\- ]/', '', $mapel);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // HEADER
        $sheet->setCellValue('A1', 'NIS');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Status');
        $sheet->setCellValue('D1', 'Total Komentar');
        $sheet->setCellValue('E1', 'Hari Berbeda');
        $sheet->setCellValue('F1', 'Quiz Selesai');

        $row = 2;

        foreach ($data as $d) {

            // Format NIS sebagai STRING agar tidak berubah menjadi notasi E
            $sheet->setCellValueExplicit(
                "A{$row}",
                $d['nis'],
                DataType::TYPE_STRING
            );

            $sheet->setCellValue("B{$row}", $d['nama']);
            $sheet->setCellValue("C{$row}", $d['status']);
            $sheet->setCellValue("D{$row}", $d['total_komentar']);
            $sheet->setCellValue("E{$row}", $d['hari_berbeda']);
            $sheet->setCellValue("F{$row}", $d['quiz_completed']);

            $row++;
        }

        // OUTPUT
        $writer = new Xlsx($spreadsheet);
        $filename = "absensi_{$kelas}_{$mapel}_pertemuan_{$id_pertemuan}.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");

        $writer->save("php://output");
    }
}