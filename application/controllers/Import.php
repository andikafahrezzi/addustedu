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
        $sheet->setCellValue('A1', 'NIS');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Password');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Image');
        $sheet->setCellValue('F1', 'Is_active');
        $sheet->setCellValue('G1', 'Kelas');
        $sheet->setCellValue('H1', 'User_type');

        // Set contoh data
        $sheet->setCellValue('A2', '12345');
        $sheet->setCellValue('B2', 'John Doe');
        $sheet->setCellValue('C2', '123456');
        $sheet->setCellValue('D2', 'john@example.com');
        $sheet->setCellValue('E2', 'default.jpg');
        $sheet->setCellValue('F2', '1');
        $sheet->setCellValue('G2', 'XI');
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

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function upload() {
        $config['upload_path'] = './assets/import/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;

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
            $header = $rows[0];
            $expected_header = ['NIS', 'Nama', 'Password', 'Email', 'Image', 'Is_active', 'Kelas', 'User_type'];
            
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
                
                // Validasi data
                if (empty($row[0])) {
                    $error_rows[] = "Baris $i: NIS tidak boleh kosong";
                    continue;
                }

                $data_siswa[] = [
                    'nis' => $row[0],
                    'nama' => $row[1],
                    'password' => password_hash($row[2], PASSWORD_DEFAULT),
                    'email' => $row[3],
                    'image' => $row[4],
                    'is_active' => $row[5],
                    'date_created' => date('Y-m-d H:i:s'),
                    'kelas' => $row[6],
                    'user_type' => $row[7],
                ];
            }

            if (!empty($error_rows)) {
                unlink($file_path);
                $this->session->set_flashdata('error', implode('<br>', $error_rows));
                redirect('import');
            }

            // Simpan ke database
            $result = $this->M_siswa->import_data($data_siswa);

            if ($result) {
                $this->session->set_flashdata('success', "Berhasil mengimport " . count($data_siswa) . " data siswa");
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data ke database');
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