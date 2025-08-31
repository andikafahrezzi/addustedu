<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Import extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_siswa');
        $this->load->library('upload');
        $this->load->helper('file');
    }

    public function index() {
        $data['title'] = 'Import Data Siswa';

        $this->load->view('admin/partials/nava');
        $this->load->view('admin/import_siswa', $data);
        $this->load->view('admin/partials/foota');
    }

    public function template() {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'nis');
        $sheet->setCellValue('B1', 'nama');
        $sheet->setCellValue('C1', 'password');
        $sheet->setCellValue('D1', 'email');
        $sheet->setCellValue('E1', 'image');
        $sheet->setCellValue('F1', 'is_active');
        $sheet->setCellValue('G1', 'id_kelas');
        $sheet->setCellValue('H1', 'user_type');

        // Set contoh data
        $sheet->setCellValue('A2', '12345678999');
        $sheet->setCellValue('B2', 'Lionel Messi');
        $sheet->setCellValue('C2', '12345678999');
        $sheet->setCellValue('D2', 'loremas@example.com');
        $sheet->setCellValue('E2', 'default.jpg');
        $sheet->setCellValue('F2', '1');
        $sheet->setCellValue('G2', '1');
        $sheet->setCellValue('H2', 'siswa');

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);

        // Header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template_import_siswa.xlsx"');
        header('Cache-Control: max-age=0');

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $sheet2 = $spreadsheet->getActiveSheet();
        $sheet2->setTitle('Referensi Kelas');
        $sheet2->setCellValue('A1', 'ID Kelas');
        $sheet2->setCellValue('B1', 'Nama Kelas');
        $sheet2->setCellValue('C1', 'Tingkat');
        $sheet2->setCellValue('D1', 'Jurusan');

        // Misalnya isi dengan data dari database
        $kelas = $this->db->get('kelas')->result();
        $row = 2;
        foreach ($kelas as $k) {
            $sheet2->setCellValue('A' . $row, $k->id);
            $sheet2->setCellValue('B' . $row, $k->nama_kelas);
            $sheet2->setCellValue('C' . $row, $k->tingkat);
            $sheet2->setCellValue('D' . $row, $k->jurusan);
            $row++;
        }
        $spreadsheet->setActiveSheetIndex(0);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function upload() {
    $config['upload_path']   = './assets/import/';
    $config['allowed_types'] = 'xls|xlsx';
    $config['max_size']      = 2048;
    $config['encrypt_name']  = true;

    $this->upload->initialize($config);

    if (!$this->upload->do_upload('file_excel')) {
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', $error);
        redirect('import');
    }

    $file_data = $this->upload->data();
    $file_path = './assets/import/' . $file_data['file_name'];

    try {
        // Load file Excel
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Validasi header
        $header = array_map('strtolower', array_map('trim', $rows[0]));
        $expected_header = ['nis','nama','password','email','image','is_active','id_kelas','user_type'];

        if ($header !== $expected_header) {
            unlink($file_path);
            $this->session->set_flashdata('error', 'Format header tidak sesuai. Silahkan download template yang disediakan.');
            redirect('import');
        }

        // Proses data
        $data_siswa = [];
        $error_rows = [];
        
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            // Validasi NIS kosong
            if (empty($row[0])) {
                $error_rows[] = "Baris $i: NIS tidak boleh kosong";
                continue;
            }

            // Cek duplikat NIS di database
            $existing = $this->db->get_where('siswa', ['nis' => $row[0]])->row();
            if ($existing) {
                $error_rows[] = "Baris $i: NIS {$row[0]} sudah terdaftar";
                continue;
            }

            // Tambahkan data valid
            $data_siswa[] = [
                'nis'          => $row[0],
                'nama'         => $row[1],
                'password'     => password_hash($row[2], PASSWORD_DEFAULT),
                'email'        => $row[3],
                'image'        => $row[4],
                'is_active'    => $row[5],
                'date_created' => date('Y-m-d'),
                'id_kelas'     => $row[6],
                'user_type'    => $row[7],
            ];
        }

        // Simpan hanya data valid
        $success_count = 0;
        if (!empty($data_siswa)) {
            $this->M_siswa->import_data($data_siswa);
            $success_count = count($data_siswa);
        }

        // Buat pesan gabungan
        $msg = '';
        if ($success_count > 0) {
            $msg .= "✅ Berhasil mengimport <b>$success_count</b> data siswa.<br>";
        }
        if (!empty($error_rows)) {
            $msg .= "⚠️ " . count($error_rows) . " data gagal:<br>" . implode('<br>', $error_rows);
        }

        if ($success_count > 0) {
            $this->session->set_flashdata('success', $msg);
        } else {
            $this->session->set_flashdata('error', $msg);
        }

        unlink($file_path);

    } catch (Exception $e) {
        if (isset($file_path) && file_exists($file_path)) {
            unlink($file_path);
        }
        $this->session->set_flashdata('error', 'Error: ' . $e->getMessage());
    }

    redirect('import');
}

}